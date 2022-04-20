<!--user orders page-->
<!--This page shows all of a users orders-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");
    require_once("../util/userUtil.php");

    $uid = $_SESSION['uid'];

    $userOrders = fetchAll($pdo, "SELECT * FROM orders WHERE userID=? AND orderStatus>0", [$uid]);

?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - User Orders</title>
    </head>

    <body>
        <h1>Orders:<h1>
        <?php
            listOrders($userOrders);
        ?>

        <a href='./userProfile.php'><button type='button'>Return to User Profile</button><a/><br>
    </body>

</html>