<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");

    $_SESSION['uid'];

    // Check if the user is a normal user. If so, they do
    // not have permission to see this page. Send them to
    // the index page.
    if ($_SESSION['permLevel'] == 0)
    {
        echo "You don't have the privileges to view this page. Returning to the home page.";
        header("refresh: 3; ../index.php");
        exit;
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
        body {
            background-color: #252424;
            color: white;
            font-family: 'Consolas';
        }
    </style>
    <?php
        require_once("../style/nav.php"); navBar();
        echo "<h3 style='margin-top:65px;color:white;font-family:Consolas;text-align:center;'>Outstanding Orders</h3>";

        try
        {
            $rs = $pdo->query("SELECT * FROM orders WHERE orderStatus > 0;");
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