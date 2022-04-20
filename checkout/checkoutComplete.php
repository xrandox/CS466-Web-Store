<!--checkout complete-->
<!--This is the final checkout page which shows a confirmation along with various other information about the order-->
<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/checkoutUtil.php");
    require_once("../util/sqlFunc.php");
?>


<!DOCTYPE html>
<html>

    <head>
        <link rel="stylesheet" href="style.php">
        <title>Web Store - Checkout</title>
    </head>

    <body>
        <h1>Checkout Complete<h1>
        <?php
            $oid = $_SESSION['oid'];

            echo "Your Order #$oid<br>";
            echo "Ordered Items:<br>";

            $products = fetchAll($pdo, "SELECT * FROM orderproducts WHERE orderID=?", [$oid]);

            foreach ($products as $product)
            {
                echo "<br>";
                $qty = $product['qty'];
                $productInfo = fetch($pdo, "SELECT * FROM products WHERE prodID=?", [$product['prodID']]);
                $name = $productInfo['prodName'];
                $price = $qty * $productInfo['price'];
                echo "Product: $name<br>Quantity: $qty<br>Total Price: $price<br>";
            }

            echo "<br>Shipping Cost: $5.00<br>";
            $total = fetch($pdo, "SELECT total FROM orders WHERE orderID=?", [$oid])['total'];
            echo "<br>Total Order Cost: $$total<br>";

            clearCart($pdo, $_SESSION['uid']);
        ?>

        <a href="../productList.php"><button type="button">Back to Shopping</button><a/><br>
    </body>

</html>

<?php

?>