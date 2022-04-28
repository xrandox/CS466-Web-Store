<!-- Shopping Cart -->
<!-- This page contains the shopping cart of the user before going to checkout -->

<?php 
    require_once("./util/creds.php");  
    require_once("./util/sessionStart.php");
    require_once("./util/checkoutUtil.php");
    require_once("./util/sqlFunc.php");
    require_once("./util/userUtil.php");
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="style.php">
    <title>Shopping Cart</title>
</head>

<body>
    <h1>Shopping Cart</h1>

    <?php
        $uid = $_SESSION['uid'];

        //get Subtotal for shopping cart
        getCartTotal($pdo, $uid);
        $total = $_SESSION['cartTotal'];

        $products = fetchAll($pdo, "SELECT * FROM shoppingCart WHERE userID = ? AND qty > 0", [$uid]);

        if($products == [])
        {
            echo "Shopping Cart is Empty<br>
            <a href='../productList.php'><button type='button'>Back to Shopping</button><a/>";
            return;
        }
    ?>


<!--Shopping table-->
<table>
    <thead>
        <tr>
            <th><b>Product</b></th>
            <th><b>Price</b></th>
            <th><b>Quantity</b></th>
            <th><b>Total</b></th>
        </tr>
    </thead>

    <tbody>
        <?php
            foreach($products as $product)
            {
                //create the product variables
                $prodInfo = fetch($pdo, "SELECT * FROM products WHERE prodID = ?", [$product['prodID']]);
                $prodName = $prodInfo['prodName'];
                $price = $qty * $prodInfo['price'];
                $qty = $product['qty'];
            }
        ?>

        <tr>
            <td><?php echo $prodName; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php echo $qty; ?></td>
        </tr>

    </tbody>
</table>

</body>

</html>

