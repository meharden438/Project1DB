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
                    $sql = "insert into Customer(user, passwrd, f_name, l_name, email, address) values(:user, :passwrd, :f_name, :l_name, :email, :address)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['user' => $username, 'passwrd' => $password, 'f_name' => $firstName, 'l_name' => $lastName, 'email' => $email, 'address' => $address]);
                    echo"Customer record created successfully";
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

    $sql = "select cat_name from Category";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo"
        <label for='categories'>Select Category</label>
        <select name='categories'>
    ";
    foreach($results as $row){
        echo "<option value='" . $row ."'>" . $row ."</option>";
    }
    
    echo "</select>";

}

function listProducts(){

}



?>