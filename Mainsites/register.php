<?php
include("../Templates/functions.php");

makeUser();

?>

<!DOCTYPE html>
<html>
<body>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"/>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"/>
        <br>
        <label for="password_again">Password Again:</label>
        <input type="password" name="password_again" id="password_again"/>
        <br>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name"/>
        <br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name"/>
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"/>
        <br>
        <label for="shipping_address">Shipping Address:</label>
        <textarea name="shipping_address" id="shipping_address" rows="5" cols="20"></textarea>
        <br>
        <input type="Submit" value="register" name="register">
    </form>
    <form method="POST" action="main.php">
        <input type="submit" value="cancel registration" name="cancel">
    </form>
    <?php showCatagoreies(); ?>
</body>

</html>