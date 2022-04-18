<!--checkout page - confirm purchase-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("./checkoutUtilities.php");
    require_once("../util/sqlFunc.php");
?>

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - Checkout</title>
    </head>

    <body>
        <h1>Checkout<h1>
        
        <?php
            $uid = $_SESSION['uid'];
            
            getCartTotal($pdo, $uid);
            $total = $_SESSION['cartTotal'];


            $products = fetchAll($pdo, "SELECT * FROM shoppingCart WHERE userID=? AND qty>0", [$uid]);
            if ($products == []) 
            {
                echo "Your shopping cart is empty<br>
                
                <a href='../productList.php'><button type='button'>Back to Shopping</button><a/>";
                return;
            }

            echo "<br>Check out with the following items?";

            foreach ($products as $product)
            {
                echo "<br><br>";
                $qty = $product['qty'];
                $productInfo = fetch($pdo, "SELECT * FROM products WHERE prodID=?", [$product['prodID']]);
                $name = $productInfo['prodName'];
                $price = $qty * $productInfo['price'];
                $imageLink = $productInfo['imageLink'];
                echo "<img src='$imageLink' alt='$name'/><br>";
                echo "$name<br>Quantity: $qty<br>Total Price: $$price";
            }

            echo "<br><br>Total Order Cost without Shipping: $$total<br>";
        ?>

        <form action="" method="post">
            <a href="../productList.php"><button type="button">Back to Shopping</button><a/> 
            <input type="submit" name="Checkout" value="Checkout"/>
        </form>
    </body>

</html>

<?php
    if (isset($_POST['Checkout'])) 
    {
        //start the order process on the backend
        $start = startCheckout($pdo);

        if ($start)
        {
            //send to shipping page
            header("Location: ./checkoutShipping.php");
            exit();
        }
        else
        {
            echo "Checkout failed";
        }
        

    }
?>

