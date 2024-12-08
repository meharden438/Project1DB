<?php
    session_start();
    require  "../Templates/functions.php";

    //if login button was click
    if(isset($_POST["Login"])){
        //set username and password into variables
        $username = $_POST["username"];
        //$password = $_POST["password"];

        if(authenticate($_POST["username"], $_POST["password"]) == 1){
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            echo "Login sucessful!";
        }
        else{
            echo "Login unsucessful! Please try again";
        }
    }
?>


<!DOCTYPE html>
<html>
    <form method="POST" action="register.php">
        <!-- login in username field -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"/>

        <!-- formatting -->
        <br>

        <!-- password button -->
        <label for="password">Password:</label>
        <input type="password" id=password name="password"/>

        <input type="submit" name="Login" value="Login">
    </form>

</html>