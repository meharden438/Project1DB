<?php
    require ("../Templates/functions.php");
    session_start();

    if(ISSET($_POST["Back"])){
        header("location: main.php");
    }
    if(ISSET($_POST["Update"])){
        $oPassword= getvalue('oPassword');
        $nPassword= getvalue('nPassword');
        $nPassword2= getvalue('nPassword2');
        $username = $_SESSION['username'];
        $result = authenticate($username, $_POST["oPassword"]);

        if($result == 1){
            if($nPassword == $nPassword2){
                $sql = "update Customer Set passwrd = SHA2(:nPassword, 256) WHERE user = :username;";
                $pdo = makeConnection();
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':nPassword', $nPassword);
                $stmt->bindParam(':username', $username);
    
                $stmt->execute();
                header("location: main.php");
                exit();
            }
            else{
                echo "New passwords do not match";
            }
        }
        else{
            echo "Incorrect password given";
        }
}

?>


<!DOCTYPE html>
<html>
    <form method="POST">
        <!-- old password field -->
        <label for="oPassword">Old Password:</label>
        <input type="password" id="oPassword" name="oPassword"/>

        <!-- formatting -->
        <br>

        <!-- password button -->
        <label for="nPassword">New Password:</label>
        <input type="password" id="nPassword" name="nPassword"/>

        <br>

        <!-- password button -->
        <label for="nPasswor2d">New Password:</label>
        <input type="password" id="nPassword2" name="nPassword2"/>

        <br>

        <input type="submit" name="Update" value="Update">
        <input type="submit" name="Back" value="Back">
    </form>


</html>