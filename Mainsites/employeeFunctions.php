<?php

    //handles changing the price of a product
    function changePrice(){
        $pID= getvalue("pID");
        $pID = (int)$pID;
        $nPrice = getvalue("nPrice");
        $nPrice = (float)$nPrice;

        $pdo = makeConnection();
        $statement = $pdo->prepare("SELECT MAX(product_ID) FROM Products");
        $result = $statement->execute();
        $row=$statement->fetch();
        $pdo=null;
        if ($pID < 1 || $pID > $row[0]){
            echo "Product ID does not exist. Please try again.";
        }
        elseif($nPrice < 0){
            echo "Please enter a price greater than zero.";
        }
        elseif($nPrice == null){
            echo "Please enter a price.";
        }
        else{
            $pdo = makeConnection();
            $statement = $pdo->prepare("Update Products set price= :nPrice where product_id=:pID");
            $statement->bindParam(':pID', $pID);
            $statement->bindParam(':nPrice', $nPrice);
            $result = $statement->execute();
            //$row=$statement->fetch();
            $pdo=null;
            echo "Price has been updated.";
        }
    }

    function restock(){
        $pID = getvalue("pID");
        $pID = (int)$pID;
        $nStock = getvalue("nStock");
        $nStock = (int)$nStock;

        $pdo = makeConnection();
        $statement = $pdo->prepare("SELECT MAX(product_ID) FROM Products");
        $result = $statement->execute();
        $row=$statement->fetch();
        $pdo=null;
        if ($pID < 1 || $pID > $row[0]){
            echo "Product ID does not exist. Please try again.";
        }
        elseif($nStock < 0){
            echo "Please enter a stock greater than zero.";
        }
        elseif($nStock == null){
            echo "Please enter a stock value.";
        }
        else{
            $pdo = makeConnection();
            $statement = $pdo->prepare("Update Products set act_stock= act_stock + :nStock where product_id=:pID;");
            $statement->bindParam(':pID', $pID);
            $statement->bindParam(':nStock', $nStock);
            $result = $statement->execute();
            $pdo=null;
            echo "Stock has been updated.";
        }
    }

?>