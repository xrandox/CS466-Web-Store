<!-- created by Ryan Park z1940877-->
<html>
<head>
    <title>Web Store - Product Inventory</title>
    <link rel="stylesheet" href="./style/inventory.css">  
</head>
<body>

<?php
    require_once("./util/creds.php"); //$pdo
    require_once("./util/sessionStart.php"); //$_SESSION['uid']
    require_once("./util/sqlFunc.php");
    require_once("./style/nav.php"); navBar();

    if($_SESSION['permLevel'] == 2)
    {
        #used fetchAll from sqlFunc.php
        $rows = fetchAll($pdo, "SELECT * FROM products", []);
        echo "<h3 style='margin-top:65px;color:white;font-family:Consolas;text-align:center;'>Inventory</h3>";
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
            </div>
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