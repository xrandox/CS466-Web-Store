<?php
    require_once("creds.php");
    require_once("sessionStart.php");
    require_once("sqlFunc.php");


    //array of state abbreviations for address
    $states = array( 
    "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC",  
    "DE", "FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA",  
    "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE",  
    "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI", "SC",  
    "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY");

    //function start checkout process
    function startCheckout($pdo) 
    {
        $_SESSION['shippingIsBilling'] = false;
        $total = $_SESSION['cartTotal'];
        $uid = $_SESSION['uid'];

        //try to create order in DB
        $stmt = insert($pdo, "INSERT INTO orders (userID) VALUES (?)", [$uid]);

        //if success
        if ($stmt)
        {
            //get all orders from user
            $rows = fetchAll($pdo, "SELECT orderID FROM orders WHERE userID=?", [$uid]);

            //get the latest order from the user
            $ordernum = count($rows) - 1;
            $thisOrder = $rows[$ordernum];
            $_SESSION['oid'] = $thisOrder['orderID'];
            $oid = $_SESSION['oid'];

            //add shopping cart to orderproducts table
            $stmt = insert($pdo, "INSERT INTO orderproducts (prodID, qty, orderID) SELECT prodID, qty, ? FROM shoppingcart WHERE userID=? and qty > 0", [$oid, $uid]);

            if($stmt)
            {
                return true;
            }

            return false;
        }
        else 
        {
            echo "Failed to create new order";
            return false;
        }

    }

    //function to get the newest orderID
    function getOrderID($pdo, $name)
    {
        $rows = fetchAll($pdo, "SELECT infoID FROM orderInfo WHERE recipientName=?", [$name]);
        $infonum = count($rows) - 1;
        return $rows[$infonum]['infoID'];
    }

    //function to total up products in the shopping cart
    function getCartTotal($pdo, $uid)
    {

        //get cart products
        $rows = fetchAll($pdo, "SELECT * FROM shoppingCart WHERE userID=?", [$uid]);

        $total = 0;

        foreach ($rows as $result)
        {
            $id = $result['prodID'];
            $qty = $result['qty'];

            //get price from product table
            $price = fetch($pdo, "SELECT price FROM products WHERE prodID=?", [$id])['price'];

            $total += ($price * $qty);
        }

        $_SESSION['cartTotal'] = $total;
        return;
    }

    //function to clean up after checkout
    function clearCart($pdo, $uid)
    {
        //clear all items from shopping cart
        insert($pdo, "UPDATE shoppingcart SET qty=0 WHERE userID=?", [$uid]);
        //reset some of the session variables just in case
        $_SESSION['cartTotal'] = 0.00;
        $_SESSION['shippingIsBilling'] = false;
        $_SESSION['shippingID'] = -1;
        $_SESSION['billingID'] = -1;
        return;
    }
?>