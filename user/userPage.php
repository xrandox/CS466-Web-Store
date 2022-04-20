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
        $email = "You have not registered an email yet, you can add an email address below";
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

            //if no email, include form to add email
            if (!$hasEmail)
            {
                echo "  <form action='' method='post'>
                            Email:
                            <input type='text' name='email' required/>
                            <input type='submit' name='addEmail' value='Add Email'/>
                        </form><br>";
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

<?php

    if(isset($_POST['addEmail']))
    {
        //try to update the email
        $stmt = execute($pdo, "UPDATE users SET email=? WHERE userID=?", [$_POST['email'], $_SESSION['uid']]);
        
        if($stmt)
        {
            //if success, refresh the page
            header("refresh: 0");
        }
        else
        {
            echo "There was a problem adding your email. Contact the owner or try again later";
        }
    }

?>