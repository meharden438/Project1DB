<?php
    session_start();
    require  "../Templates/functions.php";
    $username = $_SESSION['username'];


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
        header("Location: loginPage.php");
        exit():
    }
 ?>