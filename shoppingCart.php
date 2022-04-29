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
            <a href='./productList.php'><button type='button'>Back to Shopping</button></a>";
            return;
        }
    ?>


<!--Shopping table-->
<table border=1 cellspacing=1>
    <thead>
        <tr>
            <th><b>Product</b></th>
            <th><b>Price</b></th>
            <th><b>Quantity</b></th>
        </tr>
    </thead>

    <tbody>
        <?php
            foreach($products as $product)
            {
                //create the product variables
                $qty = $product['qty'];
                $prodInfo = fetch($pdo, "SELECT * FROM products WHERE prodID = ?", [$product['prodID']]);
                $prodName = $prodInfo['prodName'];
                $price = (float) $qty * $prodInfo['price'];
                
                
        ?>
<!-- Form the Shopping Cart Table-->
                <tr>
                <td><?php echo "$prodName"; ?></td>
                <td><?php echo "$$price";?></td>
                <td>
                    <form method='POST'>
                        <input type="number" name="qtyChange" min=<?php echo $qty?> max= <?php echo $prodInfo['qtyAvailable']?> value = "<?php echo $qty?>"/>
                     </form>
                </td>
                <td>
                    <form method='POST'>
                        <a href='shoppingCart.php'><input type="submit" name="removeit" value="Remove"/>
                </tr>
        <?php
                $pid = $product['prodID'];
                
                if(isset($_POST["removeit"]))
                {
                    $rp = $pdo->prepare("DELETE FROM shoppingCart WHERE prodID = :pd;");
                    $rs = $rp ->execute(array(':pd' => $pid));
                    
                }
                
                if(isset($_POST["qtyChange"]))
                {
                    
                }
            }
        ?>    
    
    </tbody>
</table>

<p>SubTotal: $<?php echo $total?></p>
<br>
<a href="shoppingCart.php"><button type='button'>Update Cart</button></a>
<a href='./productList.php'><button type='button'>Back to Shopping</button></a>
</body>
</html>


