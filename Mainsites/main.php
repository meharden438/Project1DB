<?php
    session_start();
    require  "../Templates/functions.php";
   
    //check if there is a valid sessions
    if($_SESSION != null){
        //sest username to who is logged in
        $username = $_SESSION['username'];
    
        //code if person whats to change their password
        if(ISSET($_POST["change"]))
        {
        header("location: updatePassword.php");
        updatePassword();
        }
?>

<!DOCTYPE html>
<html>
<body>
    <form method="POST">
        <h1> Welcome, <?php echo htmlspecialchars($username); ?> </h1>
        <input type="submit" value="change password" name="change">
        <input type="submit" value="Logout" name="Logout">
    </form>
</body>

</html>

<?php
    if(ISSET($_POST["Logout"]))
    {
        echo "<p1> <br>You are currently logged in. Would you like to logout? </p1>";
?>
<html>
    <body>
        <form method="POST">
            <input type="submit" value="Confirm Logout" name="Confirm">
        </form>
    </body>
</html>

<?php
    }

    if(ISSET($_POST["Confirm"]))
    {
        echo "logging out";
        session_unset();
        session_destroy();
        header("Location: main.php");
        exit();
    }
}
else{
 ?>

<html>
    <body>
        <form method="POST">
            <input type="submit" value="Login" name="Login">
        </form>
    </body>
</html>

<?php
     if(ISSET($_POST["Login"])){
        header("location: loginPage.php");
     }
    }
    ?>