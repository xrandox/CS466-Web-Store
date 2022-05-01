<!-- Shopping Cart -->
<!-- This page contains the shopping cart of the user before going to checkout -->

<?php 
    require_once("./util/creds.php");  
    require_once("./util/sessionStart.php");
    require_once("./util/checkoutUtil.php");
    require_once("./util/sqlFunc.php");
    require_once("./util/userUtil.php");

//Moved this because we want it to execute first thing when the page reloads, and it's better to think of this happening outside of the main loop, hence why we must pass all info via POST/GET

if(isset($_POST["update"])) 
{
    //using hidden PID to target the correct product
    $pidToUpdate = $_POST["prodID"];

    //get the difference between what used to be in the cart
    $diff = $_POST["oldQty"] - $_POST["qtyChange"];

    //if something changed, update
    if ($diff != 0) 
    {
        //using execute from sqlFunc
        $stmt = execute($pdo, "UPDATE shoppingcart SET qty=? WHERE prodID=?", [$_POST["qtyChange"], $pidToUpdate]);
        $stmt2 = execute($pdo, "UPDATE products SET qtyAvailable=qtyAvailable+? WHERE prodID=?", [$diff, $pidToUpdate]);

        //if either fails
        if(!$stmt || !$stmt2)
        {
            //failed to update smth
        }
    }
}

?>

<!--I reformatted things to make it easier for me to see how your code was structured, sorry! Feel free to change back if you prefer how you had it-->
<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart</title>
    </head>

    <body>
        <?php require_once("./style/nav.php"); navBar(); //adds navbar to top of page ?> 
        <h1 style='margin-top:65px;font-family:Consolas;text-align:center;'>Shopping Cart</h1> <!--Added styling here to fit with navbar-->

        <?php
            $uid = $_SESSION['uid'];

            //get Subtotal for shopping cart
            getCartTotal($pdo, $uid);
            $total = $_SESSION['cartTotal'];

            $products = fetchAll($pdo, "SELECT * FROM shoppingcart WHERE userID = ? AND qty > 0", [$uid]);

            if($products == [])
            {
                echo "Shopping Cart is Empty<br>
                <a href='./productList.php'><button type='button'>Back to Shopping</button></a>";
                return;
            }
        ?>


        <!--Shopping table-->
        <table border=1 cellspacing=1>
            <thead>
                <tr>
                    <th><b>Product</b></th>
                    <th><b>Item Price</b></th>
                    <th><b>Total Price</b></th>
                    <th><b>Quantity</b></th>
                    <th><b>Update/Remove</b></th>
                </tr>
            </thead>

            <tbody> 
                <?php
                foreach($products as $product)
                {
                    //create the product variables
                    $qty = $product['qty'];
                    $prodInfo = fetch($pdo, "SELECT * FROM products WHERE prodID = ?", [$product['prodID']]);
                    $prodName = $prodInfo['prodName'];
                    $price = $prodInfo['price'];
                    $totalprice = (float) $qty * $prodInfo['price'];
                    $pid = $product['prodID'];
                                
                ?>

                <!-- Form the Shopping Cart Table-->
                <tr>
                <td><?php echo "$prodName"; ?></td>
                <td><?php echo "$$price"; ?></td>
                <td><?php echo "$$totalprice";?></td>
                <td>
                    <!--Condensed forms to 1, set min to 0, added hidden value to pass pid and the original qty-->
                    <form method='POST'>
                        <input type="number" name="qtyChange" min=0 max=<?php echo $prodInfo['qtyAvailable']?> value="<?php echo $qty?>"/> 
                </td>
                <td>
                        <input type="hidden" name="oldQty" value="<?php echo $qty?>"/>
                        <input type="hidden" name="prodID" value="<?php echo $pid?>"/>
                        <input type="submit" name="update" value="Update"/>
                    </form>
                </tr>

                <?php 
                }
                ?>            
            </tbody>
        </table>

        <p>SubTotal: $<?php echo $total?></p>
        <br>
        <a href='./productList.php'><button type='button'>Back to Shopping</button></a>
        <a href='./checkout/checkoutBegin.php'><button type='button'>Proceed to Checkout</button></a>
    </body>
</html>