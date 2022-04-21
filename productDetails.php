<?php
    require_once("./util/creds.php");
    require_once("./util/sessionStart.php");

    $rs = $pdo->prepare("SELECT * FROM products WHERE prodID = ?;");
    $rs->execute(array($_GET["prodID"]));
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<body>
    <style>
        .cartButton
        {
            text-align: right;
        }
        .pDetails
        {
            border-style: solid;
            border-width: 1px;
            padding: 5px 25px 5px 25px;
            text-align: center;
        }
        .pImage
        {
            padding: 25px 0px 25px 0px;
            border-width: 1px;
            text-align: center;
        }
        .pName
        {
            text-align: center;
        }
    </style>
    
        <div class="cartButton">
            <button type="button"><img src="https://img.icons8.com/material-outlined/48/shopping-cart--v1.png" height="25" width="25" /></button>
        </div>

    <?php
    foreach($rows as $product)
    {
    ?>
        <div class="pName"> 
            <h2><?php echo $product['prodName']?></h2>
        </div>

        <div class="pImage">
            <img src=<?php echo $product['imageLink']?> />
        </div>

        <div class="pDetails">
            <p><?php echo "Description: " . $product['descr']?></p>
            <p><?php echo "Price: " . $product['price']?></p>
            <p><?php echo $product['qtyAvailable'] . " in stock"?></p>

            <form method="POST">
                <label for="qtyWanted">Quanty to order: </label>
                <input type="number" name="qtyWanted" min="0" max="<?php echo $product['qtyAvailable']?>"/><br><br>
                <input type="submit" value="Add to Shopping Cart"/> 
            </form>
        </div>

        <div>
            <form action="" method="post">
                <a href="productList.php"><button type="button">Return to Shopping</button><a/> 
            </form>
        </div>


        <?php

        // Get variables.
        $uid = $_SESSION['uid'];
        $pid = $_GET['prodID'];

        // Check if the qtyWanted input box is set.
        if (isset($_POST["qtyWanted"]))
        {
            $rs = $pdo->prepare("SELECT * FROM shoppingcart WHERE prodID = :pid && userID = :pu;");
            $rs->execute(array(':pu' => $uid,':pid' => $pid));

            // If colums were changed, then the item is already in the shopping cart.
            // In that case, update it to add more.
            if ($rs->rowCount() > 0)
            {
                /*
                    This prepare statement updates the shoppingcart table. It increases
                    the amount that is already in there to how much the user wants to add,
                    as long as the total number of products will be less than waht is in
                    stock.
                */
                $rs = $pdo->prepare("UPDATE shoppingcart SET qty = qty + :pw WHERE userID = :pu AND prodID = :pid AND qty + :pw <= (SELECT qtyAvailable FROM products WHERE prodID = :pid);");
                $success = $rs->execute(array(':pu' => $uid,':pid' => $pid, ':pw' => $_POST["qtyWanted"]));

                // If UPDATE affects any row, then the user successfully added more
                // of the product to the shopping cart.
                if($rs->rowCount() > 0)
                {
                    echo 'Updated shopping cart.';
                }
                else    // Else, the user could not add more of the product to the cart.
                {
                    echo 'Could not update the shopping cart.';
                }
            }
            else    // Else, the item is not in the shopping cart. Add it.
            {
                $rs = $pdo->prepare("INSERT INTO shoppingcart (userID, prodID, qty) VALUES ( :pu, :pid, :pw );");
                $success = $rs->execute(array(':pu' => $uid,':pid' => $pid, ':pw' => $_POST["qtyWanted"]));
        
                if($success)
                {
                    echo 'Product added to the shopping cart.';
                }
                else
                {
                    echo 'Could not add product to the shopping cart.';
                }
            }
        }
        
    }
    ?>  
</body>
</html>


