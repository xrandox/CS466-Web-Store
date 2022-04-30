<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");

    $orderID = $_GET['orderID'];

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
            <h2>Edit Order</h2>
            <form method="post">
                <label for="shipNum">Shipping Number:</label>
                <input type="text" name="shipNum" value="<?php echo $order['shippingNumber'];?>" /></br></br>

                <label for="status">Order Status:</label>
                <select name="status">
                    <option value="1" <?php if($order['orderStatus'] == 1) { echo 'selected';}?>>Order Success</option>
                    <option value="2" <?php if($order['orderStatus'] == 2) { echo 'selected';}?>>Processing</option>
                    <option value="3" <?php if($order['orderStatus'] == 3) { echo 'selected';}?>>Order Shipped</option>
                </select> </br></br>
                
                <label for="notes">Notes:</label></br>
                <textarea name="notes"><?php echo $order['notes'] ?></textarea></br></br>

                <input type="submit" name="submit" value="Save Changes" />
                <a href="./ordersFulfillment.php<?php echo "?orderID=" . $order['orderID']?>"><button type="button">Cancel Changes</button></a><br>
            </form>
            
            
        </div>

        

    <?php
        }

        if(isset($_POST["submit"]))
        {
            if ($_POST["shipNum"] != "")
            {
                $rs = $pdo->prepare("UPDATE orders SET shippingNumber = :sn, orderStatus = :st, notes = :n WHERE orderID = :o;");
                $rs->execute(array('sn' => $_POST["shipNum"], 'st' => $_POST["status"], ':n' => $_POST["notes"], ':o' => $_GET['orderID']));
                
                if($rs->rowCount() > 0)
                {
                    
                    header("Location: ordersFulfillment.php?orderID=$orderID");
                    exit();
                }
                else
                {
                    echo 'Could not update order.';
                }
            }
            else
            {
                echo 'Could not submit form. The order must have a Shipping ID!';
            }
            
        }
    ?>   

</body>
</html>