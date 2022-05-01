<!--checkout complete-->
<!--This is the final checkout page which shows a confirmation along with various other information about the order-->
<!--Coded by Ryan Sands - z1918476-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/checkoutUtil.php");
    require_once("../util/sqlFunc.php");
?>


<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="../style/orderDetails.css"/>
        <title>Web Store - Checkout</title>
    </head>

    <body>
        <?php require_once("../style/nav.php"); navBar(); ?>
        <div class="ordercontainer">
            <h3>Checkout Complete</h3>
            <?php
                $oid = $_SESSION['oid'];

                echo "<h4>Your Order #$oid</h4>";
                echo "<div class='infocontainer'>";
                echo "<p>Ordered Items:</p><hr>";

                $products = fetchAll($pdo, "SELECT * FROM orderproducts WHERE orderID=?", [$oid]);

                foreach ($products as $product)
                {
                    echo "<div class='product bottom'>";
                    $qty = $product['qty'];
                    $productInfo = fetch($pdo, "SELECT * FROM products WHERE prodID=?", [$product['prodID']]);
                    $name = $productInfo['prodName'];
                    $price = $qty * $productInfo['price'];
                    echo "Product: $name<br>Quantity: $qty<br>Total Price: $$price</div>";
                }
                echo "<hr>Shipping Cost: $5.00<br>";
                $total = fetch($pdo, "SELECT total FROM orders WHERE orderID=?", [$oid])['total'];
                echo "<br>Total Order Cost: $$total</div>";

                clearCart($pdo, $_SESSION['uid']);
            ?>
            <a href="../productList.php"><button type="button">Back to Shopping</button><a/><br>
        </div>
        
    </body>

</html>