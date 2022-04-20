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
    require_once("./util/userUtil.php"); //privCheck func
    require_once("./util/creds.php"); //$pdo
    require_once("./util/sessionStart.php"); //$_SESSION['uid']
    require_once("./util/sqlFunc.php");

    #Remove this, i used this for testing, but the userID would be passed
    $wuid = 7;
    $_SESSION['uid'] = $wuid;

    #privCheck used from userUtil.php
    $hasPriv = privCheck($pdo, $_SESSION['uid'], 1);

    if($hasPriv)
    {
        #used fetchAll from sqlFunc.php
        $rows = fetchAll($pdo, "SELECT * FROM products", []);
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

?>