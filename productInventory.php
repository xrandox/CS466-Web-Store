<html>
<head>
<title>productInventory</title>
<style>
    .aProduct{
        border-style: dotted solid;
        border-width: 1px;
        background-color: silver;
        text-align: center;
    }
</style>   
</head>
<body>

<?php
    

try{

    #require_once("./util/creds.php");
    #require_once("./util/sessionStart.php");
    require_once("./util/userUtil.php");

    #Remove this, i used this for testing, but the userID would be passed
    $uid = 7;
    $_SESSION['uid'] = $uid;

    $hasPriv = privCheck($pdo, $_SESSION['uid'], 1);


    if($hasPriv)
    {
        $rs = $pdo->query("SELECT * FROM products;");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
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
            </div>
        <?php
        }
        ?>
        </body>
        </html>
        <?php
    }
    else
    {
        echo "You dont have permissions to view this!";
        header("refresh: 3; ./productList.php");
    }
    

}
catch(PDOexception $e) {
    echo "Connection was not established to database, with reason: " . $e->getMessage();
}
?>