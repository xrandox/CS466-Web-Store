<!--user orders page-->
<!--This page shows all of a users orders-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");
    require_once("../util/userUtil.php");

    $uid = $_SESSION['uid'];
    //fetch user orders
    $userOrders = fetchAll($pdo, "SELECT * FROM orders WHERE userID=? AND orderStatus>0", [$uid]);

?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../style/orders.css"/>
        <title>Web Store - User Orders</title>
    </head>

    <body>
        <?php require_once("../style/nav.php"); navBar(); ?>
        <h1>Orders</h1>
        <?php
            listOrders($userOrders);
        ?>
    </body>

</html>