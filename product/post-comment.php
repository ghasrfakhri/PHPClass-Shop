<?php

require "../includes/config.php";

$user = new User();
$user->checkLogin();

$productId = filter_input(INPUT_POST, "productId", FILTER_SANITIZE_NUMBER_INT);
$text = filter_input(INPUT_POST, "text");
$pc = new ProductComment();
$pc->add($productId, $text, $user->getLoginUserId());
FlashMessage::add("Comment will be shown after approvement", FlashMessage::TYPE_INFO);
redirect("index.php?id=$productId");
