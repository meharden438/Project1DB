<?php
    session_Start();
    require_once ("../Templates/functions.php");
    require_once("employeeFunctions.php");
    $username = $_SESSION['username'];
    
    $pdo = makeConnection();
    $statement = $pdo->prepare("SELECT passwrdUpdated FROM Employee where username = :username");
    $statement->bindParam(":username", $username);
    $result = $statement->execute();
    $row=$statement->fetch();
    $pdo=null;

    if($row[0] == 0){
?>
        <html>
            <body>
            <form method="POST">
                <h1> Welcome, Employee <?php echo htmlspecialchars($username); ?> </h1>
                <p1>Please update your password!</p1>
                <br>
                <input type="password" value="New Password:" name="password1">
                <br>
                <input type="password" value="New Password:" name="password2">
                <br>
                <input type="submit" value="Update Password" name="pUpdated">
            </form>
            </body>
        </html>
<?php
        if(ISSET($_POST["pUpdated"])){
            $password1= getvalue('password1');
            $password2= getvalue('password2');
            $username = $_SESSION['username'];

            if($password1 == $password2){
                $sql = "update Employee Set passwrd = SHA2(:password, 256) WHERE username = :username;";
                $pdo = makeConnection();
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':password', $password1);
                $stmt->bindParam(':username', $username);

                $stmt->execute();
                $sql = "update Employee Set passwrdUpdated = 1 WHERE username = :username;";
                $pdo = makeConnection();
                $stmt = $pdo->prepare($sql);

                $stmt->bindParam(':username', $username);

                $stmt->execute();
                header("location: employeeMain.php");
                exit();
            }
            else{
                echo "Passwords do not match! Please try again.";
            }
        }
    }
    else{
        //logout button
        if(ISSET($_POST["Logout"])){
            session_unset();
            session_destroy();
            header("Location: main.php");
            exit();
        }
?>
   <!DOCTYPE html>
        <html>
            <body>
                <form method="POST">
                    <h1> Welcome, Employee <?php echo htmlspecialchars($username); ?> </h1>
                    <input type="submit" value="History" name="History">
                    <input type="submit" value="Restock a Product" name="Restock">
                    <input type="submit" value="Change Price of a product" name="cPrice">
                    <input type="submit" value="Logout" name="Logout">
                </form>
            </body>
        </html>
<?php
        if(isset($_POST["History"]))
        {
            header("location: history.php");
        }
        //if the price show button was clicked
        if(ISSET($_POST["Price"])){

        }
                

        //if the restock button was pressed
        if(ISSET($_POST["Restock"])){
            ?>
            <html>
                <body>
                    <form method="POST">
                        <p> Product ID: </p>
                        <input type="number" name="pID">
                        <P> How much is being restocked? </p>
                        <input type="number" name="nStock">
                        <br>
                        <input type="submit" value="Restock" name = "Restock">
                        <input type="submit" value="Cancel" name="Cancel">
                    </form>
                </body>

            </html>
            <?php
            if(ISSET($_POST["Restock"]))
                restock();

            if(ISSET($_POST["Cancel"]))
                header("location: employeeMain.php");
        }

        //if the change price  button was clciked
        if(ISSET($_POST["cPrice"])){
            ?>
            <html>
                <body>
                    <form method="POST">
                        <p> Product ID: </p>
                        <input type="number" name="pID">
                        <P> Price: </p>
                        <input type="text" name="nPrice">
                        <br>
                        <input type="submit" value="Change Price" name = "cPrice">
                        <input type="submit" value="Cancel" name="Cancel">
                    </form>
                </body>

            </html>
            <?php
            if(ISSET($_POST["cPrice"]))
                changePrice();


            if(ISSET($_POST["Cancel"]))
                header("location: employeeMain.php");
        }       
    }

?>