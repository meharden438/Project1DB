<?php
session_start();
$username = $_SESSION['username'];
require ("../Templates/functions.php");
?>

<!DOCTYPE html>
        <html>
            <body>
                <form method="POST">
                    <h1> Welcome, Employee <?php echo htmlspecialchars($username); ?> </h1>
                    <p>Would you like to view the history of price changes or the history of stock changes?</p>
                    <input type="submit" value="Price" name="Price">
                    <input type="submit" value="Stock" name="History">
                    <input type="submit" value="Return to Main Page" name="Return">
                </form>
            </body>
        </html>

<?php
    if(isset($_POST['Return'])){
        header("location: employeeMain.php");
        exit();
    }
    
    //collects infromation for price
    if(isset($_POST['Price'])){
        ?>
        <html>
            <body>
                <form method="POST">
                    <p>Product ID:</p>
                    <input type ="text" name="pID">
                    <input type= "submit" value="Show Price Changes" name="ShowP">
                </form>
            </body>
        </html>
        <?php
    }
    
    //displays table after submission for price was clicked
    if(isset($_POST["ShowP"])){
        $pID= getvalue("pID");
        $pID = (int)$pID;
    
        $pdo = makeConnection();
        $statement = $pdo->prepare("SELECT MAX(product_ID) FROM Products");
        $result = $statement->execute();
        $row=$statement->fetch();
        $pdo=null;
        if ($pID < 1 || $pID > $row[0]){
            echo "Product ID does not exist. Please try again.";
        }
        else{
            $pdo = makeConnection();
            $statement = $pdo->prepare("select update_date, old_price, new_price, percentage from product_history_price where product_id=:pID order by update_date desc;");
            $statement->bindParam(":pID", $pID);
            $result = $statement->execute();
            $rows = $statement->fetchAll();
            $pdo=null;

            if (empty($rows)) {
                echo "No price change history found for this product.";
            }
            else {
                echo '<table>';
                echo '<tr><th>Update Date</th><th>Old Price</th><th>New Price</th><th>Percentage</th></tr>';
                
                // Iterate over each row and display the data in the table
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['update_date']) . '</td>';
                    if($row['old_price'] == null){
                        echo '<td>  NULL  </td>';
                        echo '<td>' . htmlspecialchars($row['new_price']) . '</td>';
                        echo '<td>  NULL  </td>';
                    }
                    else{
                        echo '<td>' . htmlspecialchars($row['old_price']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['new_price']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['percentage']) . '</td>';
                    }
                    echo '</tr>';
                }
                
                echo '</table>';
            }
        }
?>

<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse:
        margin-top: 20px;
    }
</style>

<?php
    }

    //jistory button was clicked
    if(isset($_POST["History"])){
        ?>
        <html>
            <body>
                <form method="POST">
                    <p>Product ID:</p>
                    <input type ="text" name="pID">
                    <input type= "submit" value="Show Stock Changes" name="displayH">
                </form>
            </body>
        </html>
        <?php
    }


    //history update was clicked
    if(isset($_POST["displayH"])){
        $pID= getvalue("pID");
        $pID = (int)$pID;
    
        $pdo = makeConnection();
        $statement = $pdo->prepare("SELECT MAX(product_ID) FROM Products");
        $result = $statement->execute();
        $row=$statement->fetch();
        $pdo=null;
        if ($pID < 1 || $pID > $row[0]){
            echo "Product ID does not exist. Please try again.";
        }
        else{
            $pdo = makeConnection();
            $statement = $pdo->prepare("select update_date, old_stock, new_stock, changes from product_history_stock where product_id=:pID order by update_date desc;");
            $statement->bindParam(":pID", $pID);
            $result = $statement->execute();
            $rows = $statement->fetchAll();
            $pdo=null;

            if (empty($rows)) {
                echo "No stock change history found for this product.";
            }
            else {
                ?>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse:
                margin-top: 20px;
            }
        </style>
<?php
                echo '<table>';
                echo '<tr><th>Update Date</th><th>Old Stock</th><th>New Stock</th><th>Change</th></tr>';
                
                // Iterate over each row and display the data in the table
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['update_date']) . '</td>';
                    if($row['old_stock'] == null){
                        echo '<td>  NULL  </td>';
                        echo '<td>' . htmlspecialchars($row['new_stock']) . '</td>';
                        echo '<td>  NULL  </td>';
                    }
                    else{
                        echo '<td>' . htmlspecialchars($row['old_stock']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['new_stock']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['changes']) . '</td>';
                    }
                    echo '</tr>';
                }
                
                echo '</table>';
            }
        }
    }
?>