<!--Coded by Ryan Sands - z1918476-->
<style>

body {
    margin: 0px;
}

nav ul {
    font-family: 'Consolas';
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

nav li {
    float: left;
}

nav li a {
    display: block;
    color: #FEF6F5;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

nav li a:hover {
    background-color: #555;
    color: white;
}

nav .active {
    background-color: #FE731E;
    color: white;
}

</style>

<?php
    function navBar()
    {
        $permLevel = $_SESSION['permLevel']; //permission level so we know what pages to show them
        echo "<nav>
        <ul>
            <li><a href='/CS466-Web-Store/productList.php'>Home</a></li>
            <li><a href='/CS466-Web-Store/user/userProfile.php'>User Profile</a></li>
            <li><a href='/CS466-Web-Store/shoppingCart.php'>Shopping Cart</a></li>
            <li><a href='/CS466-Web-Store/user/userOrders.php'>Your Orders</a></li>
            <li><a href='/CS466-Web-Store/index.php'>Index</a></li>
            <li style='float:right'><a href='/CS466-Web-Store/login.php'>Logout</a></li>";
        if ($permLevel > 0) echo "<li style='float:right'><a href='/CS466-Web-Store/order/ordersOutstanding.php'>Order Fulfillment</a></li>";
        if ($permLevel == 2) echo "<li style='float:right'><a href='/CS466-Web-Store/productInventory.php'>Inventory</a></li>
        <li style='float:right'><a href='/CS466-Web-Store/user/allOrderHistory.php'>Full Order History</a></li>";
        echo "</ul></nav>";
    }

?>