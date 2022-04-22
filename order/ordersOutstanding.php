<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");

    echo $_SESSION['uid'];

    //add employee permission check -- /util/userUtil.php has privCheck() function, reference allOrderHistory for example
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
        try
        {
            //recommend changing the query to "SELECT * FROM orders WHERE orderStatus>0" - this limits it to only orders that have actually been placed
            $rs = $pdo->query("SELECT * FROM orders;");
            $orders = $rs->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOexception $e) 
        {
            echo "Connection was not established to database, with reason: " . $e->getMessage();
        }

        foreach($orders as $order)
        {
    ?>

        <div class="order">
            <p><?php echo "Order Number: " . $order['orderID'];?></p>
           <!-- <p><?php echo "User ID: " . $order['userID']?></p>
            <p><?php echo "Shipping ID: " . $order['shippingID']; ?></p>
            <p><?php echo "Billing ID: " . $order['billingID']; ?></p>
            <p><?php echo "Order Total: $" . $order['total']; ?></p>
            <p><?php echo "Shipping Number: " . $order['shippingNumber']; ?></p> -->


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
           <!-- <p><?php echo "Notes: " . $order['notes']?></p>-->
           <a href="./ordersFulfillment.php<?php echo "?orderID=" . $order['orderID']?>"><button type="button">View Order</button></a><br>
        </div>

    <?php
        }
    ?>   

</body>
</html>