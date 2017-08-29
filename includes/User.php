<?php

class User {

    public function __construct() {

        if (session_status() != PHP_SESSION_ACTIVE) {
            throw new Exception("User class needs session to be started");
        }
    }

    function authHash($string) {
        global $salt;

        return sha1($string . $salt);
    }

    function login($email, $password, $remember = false) {

        $stmt = Db::getPdo()->prepare("SELECT * FROM user WHERE email=:email AND password=:password");
        $res = $stmt->execute([":email" => $email, ":password" => $password]);

        if ($res === false) {
            var_dump($stmt->errorInfo());
            exit();
        }
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch();
            $_SESSION['user'] = $user;
            if ($remember) {
                $id = $user['id'];
                $secret = $this->authHash($password);

                setcookie("user_id", $id, time() + 3600 * 24 * 365, "/");
                setcookie("secret", $secret, time() + 3600 * 24 * 365, "/");
            }
            return true;
        } else {
            return false;
        }
    }

    function getUser($userId) {
        $stmt = Db::getPdo()->prepare("SELECT * FROM user WHERE id=?");
        $res = $stmt->execute([$userId]);

        if ($res === false) {
            var_dump($stmt->errorInfo());
            exit();
        }
        if ($stmt->rowCount() == 1) {
            return $stmt->fetch();
        } else {
            return false;
        }
    }

    function isLogin() {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return $this->isLoginByCookie();
        }
    }

    function isLoginByCookie() {
        $userId = filter_input(INPUT_COOKIE, "user_id", FILTER_SANITIZE_NUMBER_INT);
        $secret = filter_input(INPUT_COOKIE, "secret");
        if (empty($userId) || empty($secret)) {
            return false;
        }

        $user = $this->getUser($userId);
        if ($user === false) {
            return false;
        }

        if ($secret == $this->authHash($user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    function checkLogin() {
        if (!$this->isLogin()) {
            $_SESSION['ref_addres'] = filter_input(INPUT_SERVER, "REQUEST_URI");
            redirect(Theme::$path."/login.php");
        }
    }

    function getLoginUser() {
        if ($this->isLogin()) {
            return $_SESSION['user'];
        } else {
            return false;
        }
    }

    function getLoginUserId() {
        $user = $this->getLoginUser();

        if ($user) {
            return $user['id'];
        } else {
            return false;
        }
    }

}
