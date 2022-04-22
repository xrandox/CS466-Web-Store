<!--user utilities-->
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

    //lists all orders given an array of orders
    function listOrders($orders)
    {
        //if it's empty, there's nothing to list
        if ($orders == []) 
        {
            echo "No orders to show<br>";
            return;
        }

        //loop through list displaying each order
        echo "Click on the order for a more detailed view<br>";
        foreach ($orders as $order)
        {
            echo "<br>";
            //assign vars for convenience
            $orderID = $order['orderID'];
            $total = $order['total'];
            $shippingNumber = $order['shippingNumber'];
            $status = statusConverter($order['orderStatus']); //convert status to readable string

            //echo a link to order details page and general order info
            echo "<a href='./orderDetails.php?orderID=$orderID'>Order ID: #$orderID</a><br>
            Total Paid: $$total<br>
            Status: $status<br>";
            if ($shippingNumber != "") echo "Shipping Number: $shippingNumber<br>";
            
        }
        return;
    }
?>