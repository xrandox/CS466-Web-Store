<!--Coded by Ryan Sands - z1918476-->
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
        //reset/set some variables
        $_SESSION['shippingIsBilling'] = false;
        $total = $_SESSION['cartTotal'];
        $uid = $_SESSION['uid'];

        //try to create order in DB
        $stmt = execute($pdo, "INSERT INTO orders (userID) VALUES (?)", [$uid]);

        //if success
        if ($stmt)
        {
            //get all orders from user
            $rows = fetchAll($pdo, "SELECT orderID FROM orders WHERE userID=?", [$uid]);

            //get the id of the latest order from the user, set that as active oid
            $ordernum = count($rows) - 1;
            $thisOrder = $rows[$ordernum];
            $_SESSION['oid'] = $thisOrder['orderID'];
            $oid = $_SESSION['oid'];

            //add shopping cart products to orderproducts table
            $stmt = execute($pdo, "INSERT INTO orderproducts (prodID, qty, orderID) SELECT prodID, qty, ? FROM shoppingcart WHERE userID=? and qty > 0", [$oid, $uid]);

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

    //function to get the ID of the newest infoID
    function getInfoID($pdo, $name)
    {
        //fetch all info with recipients name
        $rows = fetchAll($pdo, "SELECT infoID FROM orderinfo WHERE recipientName=?", [$name]);
        //select the last one
        $infonum = count($rows) - 1;
        //return that info id
        return $rows[$infonum]['infoID'];
    }

    //function to total of products in $uid's shopping cart
    function getCartTotal($pdo, $uid)
    {
        //fetch cart products
        $rows = fetchAll($pdo, "SELECT * FROM shoppingcart WHERE userID=?", [$uid]);

        $total = 0;

        foreach ($rows as $result)//for each product in the cart, multiply the quantity in the cart by the price of the product
        {
            $id = $result['prodID'];
            $qty = $result['qty'];

            $price = fetch($pdo, "SELECT price FROM products WHERE prodID=?", [$id])['price'];

            $total += ($price * $qty);
        }
        //set the session variable...hindsight, idk why i didnt just return but lazy to change now
        $_SESSION['cartTotal'] = $total;
        return;
    }

    //function to clean up after checkout
    function clearCart($pdo, $uid)
    {
        //clear all items from shopping cart
        execute($pdo, "UPDATE shoppingcart SET qty=0 WHERE userID=?", [$uid]);
        //reset some of the session variables just in case
        $_SESSION['cartTotal'] = 0.00;
        $_SESSION['shippingIsBilling'] = false;
        $_SESSION['shippingID'] = -1;
        $_SESSION['billingID'] = -1;
        return;
    }
?>