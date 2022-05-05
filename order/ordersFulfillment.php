<?php
    /*
        ordersFulfillment page written by: 
        Caleb Patsch
        Z1930375
    */
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");

    $_GET['orderID'];

    // Check if the user is a normal user. If so, they do
    // not have permission to see this page. Send them to
    // the index page.
    if ($_SESSION['permLevel'] == 0)
    {
        echo "You don't have the privileges to view this page. Returning to the home page.";
        header("refresh: 3; ../index.php");
        exit;
    }

    // Fetch all the contents from the SELECT statements.
    $orders = fetchAll($pdo, "SELECT * FROM orders WHERE orderID =?;", [$_GET["orderID"]]);
    $products = fetchAll($pdo, "SELECT * FROM orderproducts WHERE orderID =?;", [$_GET["orderID"]]);

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
        echo "<h3 style='margin-top:65px;color:white;font-family:Consolas;text-align:center;'>Order Fulfillment</h3>";
        foreach($orders as $order)
        {
    ?>
        <div>
            <form action="" method="post">
                <a href="ordersOutstanding.php"><button type="button">Return to Orders</button></a>
                <a href="ordersEdit.php<?php echo "?orderID=" . $order['orderID']?>"><button type="button">Edit Order</button></a><br>
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
                            $statusString = "Order Placed";
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
            
            <p><?php echo "Notes: " . $order['notes']; ?></p>
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

        /*if(isset($_POST["notes"]))
        {
            $rs = $pdo->prepare("UPDATE orders SET notes = :n WHERE orderID = :o;");
            $rs->execute(array(':n' => $_POST["notes"], ':o' => $_GET['orderID']));
            
            if($rs->rowCount() > 0)
            {
                header("refresh:0");
                echo 'Updated notes.';
            }
            else
            {
                echo 'Did not update notes.';
            }
        }*/
    ?>   

</body>
</html>