<!--all order history page-->
<!--This page is for the owner to keep track of all orders-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");
    require_once("../util/userUtil.php");

    $uid = $_SESSION['uid'];

    //permission check
    if ($_SESSION['permLevel'] != 2)
    {
        echo "You don't have the privileges to view this page. Returning to user profile in 3 seconds;";
        header("refresh: 3; ./userProfile.php");
        exit;
    }

    //get all orders
    $allOrders = fetchAll($pdo, "SELECT * FROM orders WHERE orderStatus>0 ORDER BY orderStatus ASC", []);

?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../style/orders.css">
        <title>Web Store - All Orders</title>
    </head>

    <body>
        <?php require_once("../style/nav.php"); navBar(); ?>
        <h1>Orders:</h1>
        <?php
            listOrders($allOrders);
        ?>
    </body>

</html>