<!--checkout page - billing info-->
<!--This is the third checkout page where the user enters their billing info-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/checkoutUtil.php");
    require_once("../util/sqlFunc.php");

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
            $stmt = execute($pdo, "UPDATE orderinfo SET isBilling=1, cardNumber=?, cvc=?, expMon=?, expYear=? WHERE infoID=?", [$cardNum, $cvc, $expm, $expy, $shipID]);
            //on success
            if($stmt)
            {
                //try update the info in the orders table
                $stmt = execute($pdo, "UPDATE orders SET billingID=?, shippingID=?, total=?, orderStatus=1 WHERE orderID=?", [$shipID, $shipID, $total, $oid]);
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
            $stmt = execute($pdo, "INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip) VALUES (?,?,?,?,?)", [$name, $street, $city, $state, $zip]);
            //get the infoID for the billing info
            $billingID = getInfoID($pdo, $name);
            //try to update the card information
            $stmt2 = execute($pdo, "UPDATE orderinfo SET isBilling=1, cardNumber=?, cvc=?, expMon=?, expYear=? WHERE infoID=?", [$cardNum, $cvc, $expm, $expy, $shipID]);

            $stmt3 = execute($pdo, "UPDATE orders SET billingID=?, shippingID=?, total=?, orderStatus=1 WHERE orderID=?", [$shipID, $shipID, $total, $oid]);
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

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/checkoutForm.css">
        <title>Web Store - Checkout</title>
    </head>

    <body>
        <form action="" method="post">
        <h3>Checkout - Billing Info:</h3>
        <?php
            if(!$_SESSION['shippingIsBilling'])  //if shipping and billing address aren't the same, we need to get the billing address
            {
                echo "<label for='name'>Full Name:</label>
                <input type='text' id='name' name='name' placeholder='Enter the recipients name...' required/><br>
                <label for='street'>Street:</label>
                <input type='text' id='street' name='street' placeholder='Enter the full street address...' required/><br>
                <label for='city'>City:</label>
                <input type='text' id='city' name='city' placeholder='Enter the city name...' required/><br>
                <label for='state'>State:</label>
                <select name='state' id='state' required>";
                foreach($states as $state)
                {
                    echo "<option value='$state'>$state</option>";
                }
                echo "</select><br>
                <label for='zip'>Zip:</label>
                <input type='text' id='zip' name='zip' maxlength='5' placeholder='Enter the 5 digit zip...' required/><br>";
            }
        ?>
            <label for='cardNum'>Card Number:</label>
            <input type="text" id='cardNum' name="cardNum" placeholder='Not your actual card number please...' maxlength="19" required/>
            <label for='cvc'>CVC:</label>
            <input type="text" id='cvc' name="cvc" placeholder='123..' maxlength="3" required/>
            <label for='expm'>Expiration Month:</label>
            <input type="text" id='expm' name="expm" placeholder='02...' maxlength="2" required/>
            <label for='expy'>Expiration Year:</label>
            <input type="text" id='expy' name="expy" placeholder='2025...' maxlength="4" required/>

            <input type="submit" name="Checkout" value="Submit Order"/>

        </form>
    </body>
</html>