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
            <?php echo $product['qtyAvailable'] . " in stock"?></p>

            <form method="POST">
                <label for="qtyWanted">Quanty to order: </label>
                <input type="number" name="qtyWanted" min="0" max="<?php echo $product['qtyAvailable']?>"/><br><br>
                <input type="submit" value="Add to Shopping Cart"/> 
            </form>
        </div>

        <div>
            <form action="" method="post">
                <a href="../productList.php"><button type="button">Return to Shopping</button><a/> 
            </form>
        </div>


        <?php
        $uid = $_SESSION['uid'];
        $pid = $_GET['prodID'];

        if (isset($_POST["qtyWanted"]))
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
    ?>  
</body>
</html>


