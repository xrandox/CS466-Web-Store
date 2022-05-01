<?php
    require_once("./util/creds.php");
    require_once("./util/sessionStart.php");
    require_once("./util/sqlFunc.php"); //needed for custom execute func

    $rs = $pdo->prepare("SELECT * FROM products WHERE prodID = ?;");
    $rs->execute(array($_GET["prodID"]));
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

    // Get variables.
    $uid = $_SESSION['uid'];
    $pid = $_GET['prodID'];

    
    // Check if the qtyWanted input box is set.
    if (isset($_POST["qtyWanted"]))
    {
        //execute a REPLACE INTO (returns true on success)
        $stmt = execute($pdo, "INSERT INTO shoppingCart (userID, prodID, qty) VALUES (:u, :p, :q) ON DUPLICATE KEY UPDATE qty=qty+:q", [':u' => $uid, ':p' => $pid, ':q' => $_POST["qtyWanted"]]);
        if ($stmt) //if successfuly, execute an UPDATE for product qty
        {
            header('refresh:0');
            $stmt2 = execute($pdo, "UPDATE products SET qtyAvailable=qtyAvailable-:qty WHERE prodID=:pid", [':pid' => $pid, ':qty' => $_POST["qtyWanted"]]);
            if (!$stmt2) 
            { 
                echo "Failed to update product inventory"; 
                return; 
            } //if fail error
        }
        else 
        { 
            echo "Could not update shopping cart"; 
            return; 
        } //if fail error
    }

?>
<html>
<head>
    <link rel="stylesheet" href="./style/prodDetails.css">
    <title>Web Store - Product Details</title>
</head>
<body>
    <?php require_once("./style/nav.php"); navBar();?>

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


        <?php

        $cart = fetch($pdo, "SELECT * FROM shoppingcart WHERE userID=? AND prodID=?", [$uid,$pid]);
        if ($cart != [])
        {
            $qtyInCart = $cart['qty'];
            echo "<p>You currently have $qtyInCart of these in your cart.</p>";
        }
    }
    ?>  
</body>
</html>


