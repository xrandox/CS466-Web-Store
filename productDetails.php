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
    .aProduct{
        border-style: dotted solid;
        border-width: 1px;
        background-color: grey;
        text-align: center;
    }
</style>   
<h2>Product Details:</h2>
    <?php
    foreach($rows as $product)
    {
    ?>
        <div class="aProduct"> 
        <h2><?php echo $product['prodName']?></h2>
        <p><?php echo "Description: " . $product['descr']?></p>
        <p><?php echo $product['qtyAvailable'] . " in stock"?></p>
        </div>
        <?php
    }
    ?>  
</body>
</html>


