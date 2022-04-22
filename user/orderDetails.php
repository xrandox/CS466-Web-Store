<!--order details page-->
<!--This page displays the details of a single order, assuming the viewer has permission to view it-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");
    require_once("../util/userUtil.php");

    $oid = $_GET["orderID"];
    $uid = $_SESSION['uid'];

    //fetch order info
    $orderInfo = fetch($pdo, "SELECT * FROM orders WHERE orderID=?", [$oid]);

    //permission check
    $isOwnOrder = ($uid == $orderInfo['userID']);
    if ($_SESSION['permLevel']>0 || $isOwnOrder))
    {
        echo "You do not have the require permission to view this page. Returning to user profile in 3 seconds.";
        header("refresh: 3; ./userProfile.php");
        exit;
    }

    //fetch the rest of the order details
    $billingInfo = fetch($pdo, "SELECT * FROM orderinfo WHERE infoID=?", [$orderInfo['billingID']]);
    $shippingInfo = fetch($pdo, "SELECT * FROM orderinfo WHERE infoID=?", [$orderInfo['shippingID']]);
    $orderProducts = fetchAll($pdo, "SELECT * FROM orderproducts WHERE orderID=?", [$oid]);

    //assign to vars now for simplicity down below
    //order vars
    $total = $orderInfo['total'];
    $notes = $orderInfo['notes'];
    if ($notes == "") $notes = "N/A";
    $shippingNum = $orderInfo['shippingNumber'];
    $orderStatus = statusConverter($orderInfo['orderStatus']);
    //check if billing and shipping are the same address
    $addressIsShared = false;
    if ($orderInfo['shippingID'] == $orderInfo['billingID']) $addressIsShared = true;
    //shipping vars
    $name = $shippingInfo['recipientName'];
    $street = $shippingInfo['street'];
    $city = $shippingInfo['city'];
    $stateAbbr = $shippingInfo['stateAbbr'];
    $zip = $shippingInfo['zip'];
    //billing vars (if billing address is diff, vars are overwritten down below)
    $cardNumber = $billingInfo['cardNumber'];
    $cvc = $billingInfo['cvc'];
    $expMon = $billingInfo['expMon'];
    $expYear = $billingInfo['expYear'];

?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../util/style.php">
        <title>Web Store - Order Details</title>
    </head>

    <body>
        <?php
            //basic order info
            echo "<h1>Order #$oid<h1>";
            
            echo "Order Status: $orderStatus<br>
            Order Notes: $notes<br>";

            if ($shippingNum != "") echo "Shipping Number: $shippingNum<br>";

            echo "Shipping Cost: $5.00<br>
            Total Paid: $$total<br>";
        ?>

        <button onclick="document.getElementById('product-info').classList.toggle('hidden');">Show Products Included in Order</button>

        <p id="product-info" class="product-info hidden"> 
            <?php
                //loop through products in the order and display them
                foreach($orderProducts as $product)
                {
                    $qty = $product['qty'];
                    $productInfo = fetch($pdo, "SELECT * FROM products WHERE prodID=?", [$product['prodID']]);
                    $prodName = $productInfo['prodName'];
                    $price = $qty * $productInfo['price'];
                    $imageLink = $productInfo['imageLink'];
                    echo "<img src='$imageLink' alt='$name'/><br>";
                    echo "$prodName<br>Quantity: $qty<br>Total Price: $$price<br><br>";
                }
            ?>
        </p>

        <button onclick="document.getElementById('shipping-info').classList.toggle('hidden');">Show Shipping Info</button>

        <p id="shipping-info" class="shipping-info hidden"> 
            <?php
                echo "Name: $name<br>
                Address:<br> $street<br>$city, $stateAbbr, $zip<br>";
            ?>
        </p>

        <button onclick="document.getElementById('billing-info').classList.toggle('hidden');">Show Billing Info</button>

        <p id="billing-info" class="billing-info hidden"> 
            <?php
                if ($addressIsShared) echo "Shipping address was used for billing address<br>";
                if (!$addressIsShared)
                {
                    //if it's a diff address than shipping, we reassign the vars
                    $name = $billingInfo['recipientName'];
                    $street = $billingInfo['street'];
                    $city = $billingInfo['city'];
                    $stateAbbr = $billingInfo['stateAbbr'];
                    $zip = $billingInfo['zip'];

                    echo "Name: $name
                    Address:<br> $street<br>$city, $stateAbbr, $zip<br>";
                }

                echo "Card Info:<br>
                    Card Number: $cardNumber<br>
                    CVC: $cvc<br>
                    EXP: $expMon/$expYear";
            ?>
        </p>


        <a href='./userProfile.php'><button type='button'>Return to User Profile</button><a/><br>
    </body>

</html>