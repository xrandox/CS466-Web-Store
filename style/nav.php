<style>

body {
    margin: 0px;
}

ul {
    position: fixed;
    list-style-type: none;
    margin: 0;
    padding: 0;
    top: 0;
    overflow: hidden;
    background-color: #252424;
    width: 100%;
    z-index: 10;
}

li {
    float: left;
}

li a {
    display: block;
    color: #FEF6F5;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #555;
    color: white;
}

.active {
    background-color: #FE731E;
    color: white;
}

</style>

<?php
    function navBar()
    {
        $permLevel = $_SESSION['permLevel'];
        echo "<ul>
            <li><a href='/CS466-Web-Store/productList.php'>Home</a></li>
            <li><a href='/CS466-Web-Store/user/userProfile.php'>User Profile</a></li>
            <li><a href='/CS466-Web-Store/shoppingCart.php'>Shopping Cart</a></li>
            <li><a href='/CS466-Web-Store/user/userOrders.php'>Your Orders</a></li>
            <li><a href='/CS466-Web-Store/index.php'>Index</a></li>
            <li style='float:right'><a href='/CS466-Web-Store/login.php'>Logout</a></li>";
        if ($permLevel > 0) echo "<li style='float:right'><a href='/CS466-Web-Store/order/ordersOutstanding.php'>Order Fulfillment</a></li>";
        if ($permLevel == 2) echo "<li style='float:right'><a href='/CS466-Web-Store/user/allOrderHistory.php'>Full Order History</a></li>";
        echo "</ul>";
    }

?>