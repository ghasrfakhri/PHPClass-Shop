<?php

require "../includes/config.php";

$user = new User();
$user->checkLogin();

$commentId = filter_input(INPUT_GET, "commentId", FILTER_SANITIZE_NUMBER_INT);
$type = filter_input(INPUT_GET, "type");
$pc = new ProductComment();

$commane = $pc->get($commentId);

if ($commane['user_id'] == $user->getLoginUserId()) {
    FlashMessage::add("You cannot Rate yourself!", FlashMessage::TYPE_INFO);
} else {
    if ($type == "pos") {
        $pc->posScore($commentId, $user->getLoginUserId());
    } elseif ($type == "neg") {
        $pc->negScore($commentId, $user->getLoginUserId());
    }
    FlashMessage::add("Score saved!", FlashMessage::TYPE_INFO);
}
$ref = filter_input(INPUT_SERVER, "HTTP_REFERER");
redirect($ref);
