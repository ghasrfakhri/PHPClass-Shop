<?php

require "./includes/config.php";

//Theme::$template = null;
//
$user = new User;
$user->checkLogin();
$p = new Product;
$products = $p->getAll();

foreach ($products as $product) {
    echo "<a href='product/index.php?id=$product[id]'>$product[title]</a><br>";
}

?>
<h1>Index</h1>