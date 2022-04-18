<?php
    require_once("./util/sessionStart.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - Index</title>
    </head>

    <body>
        <?php
            $uid = $_SESSION['uid'];
            echo "Current User ID: $uid";
        ?>
        <h1>Index<h1>
        Click on one of the following buttons to be redirected<br>
        <a href="./productList.php"><button type="button">Product List Page</button><a/><br>
        <a href="./user/userPage.php"><button type="button">User Page</button><a/><br>
        <a href="./checkout/checkoutBegin.php"><button type="button">Checkout Page</button><a/><br>
        <!--If you want to add one of your pages to test, just copy the unknown page and change the href and label-->
        <a href=""><button type="button">Unknown Page</button><a/><br>
    </body>

</html>