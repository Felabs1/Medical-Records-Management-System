<?php

session_start();

if(!isset($_SESSION['full_name']) && $_SESSION['full_name'] !== true){
    header("location: login.php");
}

?>

<div class="w3-bar w3-top w3-blue">
    <a class="w3-bar-item">Afya Medical Store</a>
    <div class="w3-right">
        <a class="w3-bar-item" href="index.php"><small>Dashboard</small></a>

        <a class="w3-bar-item" href="stock.php"><small>Stock</small></a>
        <a class="w3-bar-item" href="categories.php"><small>Category</small></a>
        <a class="w3-bar-item" href="products.php"><small>Products</small></a>
        <a class="w3-bar-item" href="logout.php"><small>Log Out</small></a>
    </div>

</div>