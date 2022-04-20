<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");
    require_once("./userUtil.php");

    $uid = $_SESSION['uid'];

    //priv check
    $hasPriviledge = privCheck($pdo, $uid, 2);
    if (!$hasPriviledge)
    {
        echo "You don't have the priviledges to view this page. Returning to user profile in 3 seconds";
        header("refresh: 3; url: ./userProfile.php");
    }

    //get all orders
    $allOrders = fetchAll($pdo, "SELECT * FROM orders WHERE userID=? AND orderStatus>0 ORDER BY orderStatus ASC", [$uid]);

?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - All Orders</title>
    </head>

    <body>
        <h1>Orders:<h1>
        <?php
            listOrders($allOrders);
        ?>

        <a href='./userProfile.php'><button type='button'>Return to User Profile</button><a/><br>";
    </body>

</html>