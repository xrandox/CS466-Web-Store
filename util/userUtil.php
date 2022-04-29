<!--Coded by Ryan Sands - z1918476-->
<!--user utilities-->
<style>
.smallcontainer {
    display: block;
    text-align: center;
    width: 50%;
    position: relative;
    left: 25%;
    background-color: rgba(255,255,255,0.13);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(13, 12, 20, 0.6);
    padding: 5px;
    margin-top: 15px;
}

.smallcontainer * {
    color: white;
    font-family: 'Consolas';
    color: #ffffff;
}

.smallcontainer h3 {
    color: white;
    margin-top: 5px;
    margin-bottom: 0px;
    font-size: 18px;
    font-weight: 500;
    line-height: 20px;
}

.smallcontainer:hover {
    background-color: #bebebe;
    color: #black;
}

a {
    text-decoration: none;
}


</style>
<?php
    require_once("/creds.php");
    require_once("/sessionStart.php");
    require_once("/sqlFunc.php");

    //converts the status int into a readable string
    function statusConverter($status)
    {
        switch ($status) {
            case 0:
                return "This order was never completed";
            case 1:
                return "Awaiting Processing";
            case 2:
                return "Processing";
            case 3:
                return "Shipped";
            default:
                return "Invalid status";
        }
    }

    //lists all orders, given an array of orders
    function listOrders($orders)
    {
        //if array is empty, there's nothing to list
        if ($orders == []) 
        {
            echo "<div class='smallcontainer'><p>No orders to show</p></div>";
            return;
        }

        //loop through list displaying each order
        echo "<p style='text-align:center;margin-bottom:15px;font-family:Consolas;color:#ffffff;'>Click on the order for a more details</p>";
        foreach ($orders as $order)
        {
            //assign vars for convenience
            $orderID = $order['orderID'];
            $total = $order['total'];
            $shippingNumber = $order['shippingNumber'];
            $status = statusConverter($order['orderStatus']); //convert status to readable string

            //echo a link to order details page and general order info
            echo "<div class='smallcontainer'><a href='./orderDetails.php?orderID=$orderID'>";
            echo "<h3>Order ID #$orderID</h3>
            <p>Total Paid: $$total<br>
            Status: $status<br>";
            if ($shippingNumber != "") echo "Shipping Number: $shippingNumber<br>";
            echo "</p></a></div>";
        }
        return;
    }
?>