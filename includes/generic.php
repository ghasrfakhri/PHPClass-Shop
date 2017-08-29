<?php

function isPost() {
//    return ($_SERVER['REQUEST_METHOD'] == "POST");
    return (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "POST");
}

function redirect($url) {
    header("Location: $url");
    Theme::$template = null;
    exit();
}
