<!--checkout page - confirm purchase-->
<!--This page is the first checkout page that prompts the user to confirm they want to check out with the products in their cart-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/checkoutUtil.php");
    require_once("../util/sqlFunc.php");

    //if they choose to checkout
    if (isset($_POST['Checkout'])) 
    {
        //start the order process on the backend
        $start = startCheckout($pdo);

        if ($start) //if successful
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

<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../style/orderDetails.css">
        <link rel="stylesheet" href="../style/checkout.css">
        <title>Web Store - Checkout</title>
    </head>

    <body>
        <?php require_once("../style/nav.php"); navBar(); ?>
        <div class="ordercontainer">
            <h3>Checkout</h3>
            
            <?php
                $uid = $_SESSION['uid'];
                
                //get current cart total
                getCartTotal($pdo, $uid);
                $total = $_SESSION['cartTotal'];

                //get all products
                $products = fetchAll($pdo, "SELECT * FROM shoppingCart WHERE userID=? AND qty>0", [$uid]);
                if ($products == []) //if there are none, stop and say so
                {
                    echo "<p>Your shopping cart is empty</p>";
                    return;
                }

                echo "<p>Check out with the following items?</p>";

                //loop through to show all products
                foreach ($products as $product)
                {
                    echo "<div class='product'>";
                    $qty = $product['qty'];
                    $productInfo = fetch($pdo, "SELECT * FROM products WHERE prodID=?", [$product['prodID']]);
                    $name = $productInfo['prodName'];
                    $price = $qty * $productInfo['price'];
                    $imageLink = $productInfo['imageLink'];
                    echo "<img src='$imageLink' alt='$name'/><br>";
                    echo "$name<br>Quantity: $qty<br>Total Price: $$price</div>";
                }

                echo "<p>Total Order Cost without Shipping: $$total</p>";
            ?>

            <form action="" method="post">
                <a href="../productList.php"><button type="button">Back to Shopping</button><a/> 
                <input type="submit" name="Checkout" value="Checkout"/>
            </form>
        </div>
    </body>

</html>

