<?php
require 'includes/config.php';
if (isPost()) {
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $remember = (int) filter_input(INPUT_POST, "remember", FILTER_SANITIZE_NUMBER_INT);

    $user = new User;
    if ($user->login($email, $password, $remember)) {
        if (isset($_SESSION['ref_addres'])) {
            redirect($_SESSION['ref_addres']);
        } else {
            redirect("index.php");
        }
    } else {
        $msg = "Invalid Email or Password";
    }
}
?><!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($msg)) {
            echo $msg;
        }
        ?>
        <form method="post">
            <label>Email: <input type="email" name="email"></label><br>
            <label>Password: <input type="password" name="password"></label><br>
            <label>Remember Me: <input type="checkbox" name="remember" value="1"></label><br>
            <input type="submit" value="login">
        </form>
    </body>
</html>
