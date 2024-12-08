<?php
 function getvalue($value){
    if (isset($_POST[$value])){
      return htmlspecialchars($_POST[$value], ENT_QUOTES, 'UTF-8');
    } else{
      return '';
    }
  }

function makeConnection(){
    try{
        $dsn = "mysql:host=classdb.it.mtu.edu;dbname=dbwrobel";
        $username = "dbwrobel";
        $password = "Applebees1!";
        $pdo = new PDO($dsn, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo"Connected successfully!<br>";
        return $pdo;
    }catch(PDOException $e){
        echo "Connection failed: ".$e->getMessage();
    }

}

function authenticate($user, $passwd){
    try{
        $pdo = makeConnection();
        $statement = $pdo->prepare("SELECT count(*) FROM Customer where user = :username and passwrd = sha2(:passwd,256)");
        $statement->bindParam(":username", $user);
        $statement->bindParam(":passwd", $passwd);
        $result = $statement->execute();
        $row=$statement->fetch();
        $pdo=null;
        return $row[0];
    }
    catch(PDOException $e){
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function makeUser(){
    if (isset($_POST['register'])){
        //establish connection to database
        $pdo = makeConnection();

        //get all field values
        $username= getvalue('username');
        $password= getvalue('password');
        $passwordAgain= getvalue('password_again');
        $firstName= getvalue('first_name');
        $lastName= getvalue('last_name');
        $email= getvalue('email');
        $address= getvalue('shipping_address');
        
        if(!empty($username) && !empty($password) && !empty($email)){
            if($password == $passwordAgain){
                try{
                    $sql = "call insert_customer(:user, :passwrd, :f_name, :l_name, :email, :address)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['user' => $username, 'passwrd' => $password, 'f_name' => $firstName, 'l_name' => $lastName, 'email' => $email, 'address' => $address]);
                    header("Location: main.php");
                }catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                }
            }
            else{
                echo "password does not match";
            }
        }else{
            echo "All fields must be filled";
        }
    }
}

function showCatagoreies(){
    $pdo = makeConnection();

    $sql = "select * from Category;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo"
        <form method='POST'>
        <label for='category'>Select Category</label>
        <select name='category'>
            <option value='all_products'>All products</option>
    ";
    foreach($results as $row){
        echo "<option value='" . $row['cat_Name'] ."'>" . $row['cat_Name'] ."</option>";
    }
    
    echo"
        </select>
        <input type='submit' value='Search' name='search'>
        </form>
    ";

}

function getCID(){
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if (isset($_SESSION['username'])){
        $pdo = makeConnection();

        $sql = "select c_id from Customer where user = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $_SESSION['username']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result){
            return $result['c_id'];
        }
        

    }

    return null;
}

function addToCart($product, $number){
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if (isset($_POST['product_to_add']) && isset($_POST['num_add_to_cart'])){
        $pdo = makeConnection();
        $cID = getCID();
        
        if ($cID){
            for ($i = 0; $i < $number; $i++){
                $stmt = $pdo->prepare("insert into In_Cart (c_id, product_id) values (:c_id, :product_id)");
                $stmt->execute(['c_id' => $cID, 'product_id' => $product]);
            }
        }   
    }
}

function listProducts(){
    if (session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if (isset($_POST['search']) && isset($_POST['category'])){

        $category = htmlspecialchars($_POST['category']);

        $pdo = makeConnection();

        $sql = "select * from Products";

        if ($category != 'all_products'){
            $sql = "select * from Products where category = :category";   
        }

        $stmt = $pdo->prepare($sql);

        if ($category != 'all_products'){
            $stmt->execute(['category' => $category]);
        }else{
            $stmt->execute();
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($results)){
            echo "<p>No products for the selected category</p>";
        }else{     
                foreach($results as $row){
                    echo "<form method='POST'>";
                    echo "<p>" . $row['product_name'] . "</p>";
                    echo "<p>$" . $row['price'] . "</p>";
                    echo "<img src='../Images/" . $row['image'] . "' width='100'>";
                    
                    if (isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == true){
                        echo "
                            <input type='number' id='num_add_to_cart' name='num_add_to_cart'>
                            <input type='hidden' name='product_to_add' id='product_to_add' value='" . $row['product_id'] ."'>
                            <input type='submit' value='add to cart' name='add_to_cart'>
                        ";
                    }
                    echo "<br>";
                    echo "</form>";
                }
                
                if (isset($_POST['product_to_add']) && isset($_POST['num_add_to_cart'])){
                    addToCart($_POST['product_to_add'], (int)$_POST['num_add_to_cart']);
                }
        }
    }
}

?>