<?php
    require_once("../util/creds.php");
    require_once("../util/sessionStart.php");
    require_once("../util/sqlFunc.php");

    //checks if user $uid has $level and returns a boolean, true if they do, false if not
    //$level 0 = normal user, 1 = employee, 2 = owner
    function privCheck($uid, $level)
    {
        $userInfo = fetch($pdo, "SELECT * FROM users WHERE userID=?", [$uid]);

        //owner check
        if ($level = 2)
        {
            if ($userInfo['isOwner'] == 1) return true;
            else return false;
        }

        //employee check
        if ($level = 1)
        {
            if ($userInfo['isEmployee'] == 1) return true;
            else return false;
        }

        //if not checking for owner or employee, everyone is user
        return true;
    }

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

    function listOrders($orders)
    {
        if ($orders = []) 
        {
            echo "No orders to show";
            return;
        }

        $orderNum = 1;
        echo "Click on the order for a more detailed view<br>";
        foreach ($orders as $order)
        {
            //assign vars for convenience
            $orderID = $order['orderID'];
            $total = $order['total'];
            $shippingNumber = $order['shippingNumber'];
            $status = statusConverter($order['orderStatus']);

            echo "<a href='./orderDetails.php?orderID=$orderID'>Order Number $orderNum:</a><br>
            Order ID: #$orderID<br>
            Total Paid: $total<br>
            Order Status: $status<br>";
            if ($shippingNumber != "") echo "Shipping Number: $shippingNumber<br>";
            
            $orderNum += 1;
        }
        return;
    }
?>