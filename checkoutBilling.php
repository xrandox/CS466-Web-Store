<!--checkout page - billing info-->
<?php
    require_once("creds.php");
    require_once("sessionStart.php");
    require_once("checkoutUtilities.php");
    require_once("sqlFunc.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - Checkout</title>
    </head>

    <body>
        <h1>Checkout<h1>
        <form action="" method="post">
        Billing Info:<br>
        <?php
            if(!$_SESSION['shippingIsBilling']) 
            {
                echo "Full Name:
                <input type='text' name='name'/><br>
                Street:
                <input type='text' name='street'/><br>
                City:
                <input type='text' name='city'/><br>
                State:
                <select name='state' id='state'>";
                foreach($states as $state)
                {
                    echo "<option value='$state'>$state</option>";
                }
                echo "</select><br>
                Zip:
                <input type='text' name='zip' maxlength='5'/><br>";
            }
        ?>
            Card Number:
            <input type="text" name="cardNum" maxlength="19" required/><br>
            CVC:
            <input type="text" name="cvc" maxlength="3" required/><br>
            Expiration Month:
            <input type="text" name="expm" maxlength="2" required/>
            Expiration Year:
            <input type="text" name="expy" maxlength="4" required/><br>

            <input type="submit" name="Checkout" value="Submit Order"/>

        </form>
    </body>
</html>

<?php
    if(isset($_POST['Checkout'])) 
    {
        $cardNum = $_POST['cardNum'];
        $cvc = $_POST['cvc'];
        $expm = $_POST['expm'];
        $expy = $_POST['expy'];
        $shipID = $_SESSION['shippingID'];
        $oid = $_SESSION['oid'];
        $total = $_SESSION['cartTotal'] + 5.0; //add arbitrary number for shipping fees

        //if they use same info
        if($_SESSION['shippingIsBilling'])
        {
            //try to update with billing info
            $stmt = insert($pdo, "UPDATE orderInfo SET isBilling=1, cardNumber=?, cvc=?, expMon=?, expYear=? WHERE infoID=?", [$cardNum, $cvc, $expm, $expy, $shipID]);
            //on success
            if($stmt)
            {
                //try update the info in the orders table
                $stmt = insert($pdo, "UPDATE orders SET billingID=?, shippingID=?, total=? WHERE orderID=?", [$shipID, $shipID, $total, $oid]);
                //on success
                if($stmt)
                {
                    //send to checkout complete page
                    header("Location: ./checkoutComplete.php");
                    exit();
                }
            }
        }
        else
        {
            $name = $_POST['name'];
            $street = $_POST['street'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $zip = $_POST['zip'];
            
            //insert billing address
            $stmt = insert($pdo, "INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip) VALUES (?,?,?,?,?)", [$name, $street, $city, $state, $zip]);
            //get the infoID for the billing info
            $billingID = getOrderID($pdo, $name);
            //try to update the card information
            $stmt2 = insert($pdo, "UPDATE orderInfo SET isBilling=1, cardNumber=?, cvc=?, expMon=?, expYear=? WHERE infoID=?", [$cardNum, $cvc, $expm, $expy, $shipID]);

            $stmt3 = insert($pdo, "UPDATE orders SET billingID=?, shippingID=?, total=?, orderStatus=1 WHERE orderID=?", [$shipID, $shipID, $total, $oid]);
            //on success
            if($stmt3)
            {

                //send to checkout complete page
                header("Location: ./checkoutComplete.php");
                exit();
            }
        }
    }
?>