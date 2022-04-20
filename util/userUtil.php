<!--user utilities-->
<?php
    require_once("./creds.php");
    require_once("./sessionStart.php");
    require_once("./sqlFunc.php");

    //checks if user $uid has $level and returns a boolean, true if they do, false if not
    //$level 0 = normal user, 1 = employee or owner, 2 = owner
    function privCheck($pdo, $uid, $level)
    {
        $userInfo = fetch($pdo, "SELECT * FROM users WHERE userID=?", [$uid]);

        //owner check
        if ($level = 2)
        {
            if ($userInfo['isOwner'] == 1) return true;
            else return false;
        }

        //atleast an employee (also counts owner)
        if ($level = 1)
        {
            if ($userInfo['isOwner'] == 1 || $userInfo['isEmployee'] == 1) return true;
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