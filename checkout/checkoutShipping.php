<!--checkout page - shipping info-->
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
            Shipping Info:<br>
            Full Name:
            <input type="text" name="name" required/><br>
            Street:
            <input type="text" name="street" required/><br>
            City:
            <input type="text" name="city" required/><br>
            State:
            <select name="state" id="state" required>
            <?php 
            foreach($states as $state)
            {
                echo "<option value='$state'>$state</option>";
            }
            ?>
            </select><br>
            Zip:
            <input type="text" name="zip" maxlength="" required/><br>
            Use same address for billing info? 
            <input type="checkbox" name="alsoBilling"/><br>

            <input type="submit" name="Checkout" value="Submit Shipping Info"/>

        </form>
    </body>

</html>


<?php
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
            $_SESSION['shippingID'] = getOrderID($pdo, $name);
            //continue to next checkout page
            header("Location: ./checkoutBilling.php");
            exit();
        }
    }
?>


