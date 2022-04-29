<!--checkout page - shipping info-->
<!--This is the second checkout page where the user adds their shipping info-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/checkoutUtil.php");
    require_once("../util/sqlFunc.php");

    if(isset($_POST['Checkout'])) 
    {
        $name = $_POST['name'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $isBilling = $_POST['alsoBilling'];

        //if shipping info is shared with billing, flip the bool
        if ($isBilling) { $_SESSION['shippingIsBilling'] = true; }

        //insert statement
        $stmt = execute($pdo, "INSERT INTO orderinfo (recipientName, street, city, stateAbbr, zip) VALUES (?,?,?,?,?)", [$name, $street, $city, $state, $zip]);
        //on success
        if ($stmt)
        {
            //save the shipping id
            $_SESSION['shippingID'] = getInfoID($pdo, $name);
            //continue to next checkout page
            header("Location: ./checkoutBilling.php");
            exit();
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
            <h3>Checkout - Shipping Info:</h3>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter the recipients name..." required/><br>
            <label for="street">Street:</label>
            <input type="text" id="street" name="street" placeholder="Enter the full street address..." required/><br>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="Enter the city name..." required/><br>
            <label for="state">State:</label>
            <select name="state" id="state" required>
            <?php 
            foreach($states as $state)
            {
                echo "<option value='$state'>$state</option>";
            }
            ?>
            </select><br>
            <label for="zip">Zip:</label>
            <input type="text" id="zip" name="zip" maxlength="5" placeholder="Enter the 5 digit zip..." required/><br>
            <label class="inline" for="alsoBilling">Use same address for billing info?</label>
            <input class="inline" type="checkbox" id="alsoBilling" name="alsoBilling"/><br>
            <input type="submit" name="Checkout" value="Submit Shipping Info"/>
        </form>
    </body>
</html>