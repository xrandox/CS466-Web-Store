<!--This page was just for a quick link to all pages for testing-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("./util/sessionStart.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' href='./style/home.css'/>
        <title>Web Store - Index</title>
    </head>

    <body>
        <?php require_once("./style/nav.php"); navBar();?>
        <h1>Index<br>
        Click on one of the following buttons to be redirected<br>
        <a href="./productList.php"><button type="button">Product List Page</button><a/><br>
        <a href="./user/userProfile.php"><button type="button">User Profile</button><a/><br>
        <a href="./checkout/checkoutBegin.php"><button type="button">Checkout Page</button><a/><br>
        <!--If you want to add one of your pages to test, just copy the unknown page and change the href and label-->
        <a href=""><button type="button">Unknown Page</button><a/><br></h1>
    </body>

</html>