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
    body {
        background-color: #252424;
    }
</style>   
</head>
<body>
<h3 style='margin-top:65px;color:white;font-family:Consolas;text-align:center;'>Moch products</h3>
<?php

    require_once("./util/creds.php");
    require_once("./util/sessionStart.php");
    require_once("./style/nav.php"); navBar();
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
    <!-- Display the price-->
    <p><?php echo "$" . $product['price']?></p>
    <!-- Display amount of stock-->
    <p><?php echo $product['qtyAvailable'] . " in stock"?></p>
    <!-- Displays a button for each product, allowing them to go to productDetails.php-->
    <a href="./productDetails.php<?php echo "?prodID=" . $product['prodID']?>"><button type="button">View details</button><a/><br>
    </div>
<?php
}
?>
</body>
</html>