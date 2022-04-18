<!--user page-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");

    $uid = $_SESSION['uid'];

    //get user info
    $userInfo = fetch($pdo, "SELECT * FROM users WHERE userID=?", [$uid]);

    //assign to variables for ease of use
    $username = $userInfo['username'];
    $password = $userInfo['pass'];
    $isEmployee = $userInfo['isEmployee'];
    $isOwner = $userInfo['isOwner'];
    $email = $userInfo['email'];
    $hasEmail = true;
    if ($email == "") 
    { 
        $hasEmail = false;
        $email = "You have not registered an email yet, click on Add Email button below to add an email address";
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - User Page</title>
    </head>

    <body>
        <h1>User Page<h1>
        <?php
            echo "Username: $username<br>Email: $email<br>";

            //if no email, include button to show email
            if (!$hasEmail)
            {
                echo "<a href='./user/addEmail.php'><button type='button'>Add Email</button><a/><br>";
            }

            echo "<a href='./user/shoppingCart.php'><button type='button'>View Shopping Cart</button><a/><br>";
            
            //if employee, show outstanding orders
            if ($isEmployee || $isOwner)
            {
                echo "<h3>Employee Only:<h3>
                <a href='./outstandingOrders.php'><button type='button'>Order Fulfillment</button><a/><br>";
            }

            //if owner, show inventory page
            if ($isOwner)
            {
                echo "<h3>Owner Only:<h3>
                <a href='./productInventory.php'><button type='button'>Product Inventory</button><a/><br>
                <a href='./allOrderHistory.php'><button type='button'>View All Orders</button><a/><br>";
            }

        ?>
    </body>

</html>