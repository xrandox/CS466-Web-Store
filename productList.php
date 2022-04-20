<html>
<head>
<title>productList</title>
<style>
    .aProduct{
        border-style: dotted solid;
        border-width: 1px;
        background-color: grey;
        text-align: center;
    }
</style>   
</head>
<body>
<h2>Moch products</h2>
<?php

    require_once("./util/creds.php");
    require_once("./util/sessionStart.php");
/*
    echo($_SESSION['uid']);
*/
try{

    $rs = $pdo->query("SELECT * FROM products;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

}
catch(PDOexception $e) {
    echo "Connection was not established to database, with reason: " . $e->getMessage();
}

?>    
<?php
foreach($rows as $product)
{
?>
    <!-- Create a div foreach product-->
    <div class="aProduct"> 
    <!--Out put the prodName -->
    <h2><?php echo $product['prodName']?></h2>
    <?php
    /* store the prodID in session */
    $_SESSION['prodID'] = $product['prodID'];
    ?>
    <!-- Display the price-->
    <p><?php echo "$" . $product['price']?></p>
    <!-- Display amount of stock-->
    <p><?php echo $product['qtyAvailable'] . " in stock"?></p>
    <!-- Displays a button for each product, allowing them to go to productDetails.php-->
    <a href="./productDetails.php<?php echo "?prodID=" . $_SESSION['prodID']?>"><button type="button">View details</button><a/><br>
    </div>
<?php
}
?>
</body>
</html>