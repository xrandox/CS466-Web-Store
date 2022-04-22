<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");

    echo $_GET['orderID'];

    try
        {
            $rs = $pdo->prepare("SELECT * FROM orders WHERE orderID =?;");
            $rs->execute(array($_GET["orderID"]));
            $orders = $rs->fetchAll(PDO::FETCH_ASSOC);

            $rs = $pdo->prepare("SELECT * FROM orderproducts WHERE orderID =?;");
            $rs->execute(array($_GET["orderID"]));
            $products = $rs->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOexception $e) 
        {
            echo "Connection was not established to database, with reason: " . $e->getMessage();
        }
?>
<html>
<body>
    <style>
        .order
        {
            border-style: solid;
            border-width: 1px;
            padding: 5px 5px 5px 5px;
        }
    </style>
    <?php

        foreach($orders as $order)
        {
    ?>
        <div>
            <form action="" method="post">
                <a href="ordersOutstanding.php"><button type="button">Return to Orders</button></a> 
            </form>
        </div>

        <div class="order">
            <p><?php echo "Order Number: " . $order['orderID'];?></p>
            <p><?php echo "User ID: " . $order['userID']?></p>
            <p><?php echo "Shipping ID: " . $order['shippingID']; ?></p>
            <p><?php echo "Billing ID: " . $order['billingID']; ?></p>
            <p><?php echo "Order Total: $" . $order['total']; ?></p>
            <p><?php echo "Shipping Number: " . $order['shippingNumber']; ?></p>


            <p><?php
                    $status = $order['orderStatus'];
                    $statusString = "";

                    switch ($status)
                    {
                        case 0:
                            $statusString = "Checkout";
                            break;
                        case 1:
                            $statusString = "Order Success";
                            break;
                        case 2:
                            $statusString = "Processing";
                            break;
                        case 3:
                            $statusString = "Shipped";
                            break;
                    }

                    echo "Order Status: " . $statusString;
               ?></p>
            <?php echo "Notes: " . $order['notes']?>

        </div>

        <?php
        }
        
        foreach($products as $product)
        {
        ?>

        <div class="order">
            <p><?php echo "Product ID: " . $product['prodID']?></p>
            <p><?php echo "Quantity: " . $product['qty']?></p>
        </div>

    <?php


        }
    ?>   

</body>
</html>