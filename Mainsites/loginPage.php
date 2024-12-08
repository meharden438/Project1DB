<?php
    session_start();
    require  "../Templates/functions.php";

    //if login button was click
    if(isset($_POST["Login"])){
        //set username and password into variables
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(authenticate($_POST["username"], $_POST["password"]) == 1){
            $_SESSION['username'] = $_POST['username'];
            header("Location: main.php");
        }
        else{
            echo "Login unsucessful! Please try again";
        }
    }

    //if the register button was clicked
    if(isset($_POST["Register"])){
        header("Location: register.php");
    }
?>


<!DOCTYPE html>
<html>
    <form method="POST">
        <!-- login in username field -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"/>

        <!-- formatting -->
        <br>

        <!-- password button -->
        <label for="password">Password:</label>
        <input type="password" id=password name="password"/>

        <br>

        <input type="submit" name="Login" value="Login">
        <input type="submit" name="Register" value="Register">
    </form>


</html>