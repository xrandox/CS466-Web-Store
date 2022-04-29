<!--user profile page-->
<!--This page displays the users basic info and links to various other pages-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");

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

    $uid = $_SESSION['uid'];

    //get user info
    $userInfo = fetch($pdo, "SELECT * FROM users WHERE userID=?", [$uid]);

    //assign to variables for ease of use
    $username = $userInfo['username'];
    $password = $userInfo['pass'];
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
        <link rel="stylesheet" href="../style/user.css">
        <title>Web Store - User Profile</title>
    </head>

    <body>
        <?php require_once("../style/nav.php"); navBar(); ?>
        <div class="container">
            
            <?php
                echo "<h2>User Profile</h2><div class='smallcontainer'><h3>Username:</h3>$username</div><br><div class='smallcontainer'><h3>Email:</h3>$email</div><br>";

                //if no email, include form to add email
                if (!$hasEmail)
                {
                    echo "  <form action='' method='post'>
                                <input type='text' name='email' id='email' placeholder='Enter an email to add...' required/>
                                <input type='submit' name='addEmail' value='Add Email'/>
                            </form><br>";
                }

                echo "<a href='./shoppingCart.php'><button type='button'>View Shopping Cart</button><a/><br>";
                echo "<a href='./userOrders.php'><button type='button'>View Orders</button><a/><br>";

                
                //if employee, show outstanding orders
                if ($_SESSION['permLevel']>0)
                {
                    echo "<h3>Employee Only:</h3>
                    <a href='./outstandingOrders.php'><button type='button'>Order Fulfillment</button><a/><br>";
                }

                //if owner, show inventory page and order history
                if ($_SESSION['permLevel']>1)
                {
                    echo "<h3>Owner Only:</h3>
                    <a href='../productInventory.php'><button type='button'>Product Inventory</button><a/><br>
                    <a href='./allOrderHistory.php'><button type='button'>View All Orders</button><a/><br>";
                }

            ?>
        </div>
    </body>
</html>