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

    $sql = "select * from Category";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo"
        <form method='POST'>
        <label for='categories'>Select Category</label>
        <select name='categories'>
            <option value='select_category'>Select Category</option>
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

function listProducts(){
    $pdo = makeConnection();

    if(isset($_POST['Search'])){
        
    }
}


?>