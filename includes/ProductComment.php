<?php

class ProductComment {

    function add($productId, $text, $userId) {
        $stmp = Db::getPdo()->prepare("INSERT INTO product_comment  SET product_id=:productId, user_id=:userId"
                . ", text=:text");
        $res = $stmp->execute(["productId" => $productId, "userId" => $userId, "text" => $text]);

        if ($res === false) {
            var_dump($stmp->errorInfo());
            exit();
        }
        return Db::getPdo()->lastInsertId();
    }

    function get($commentId) {
        $stmp = Db::getPdo()->prepare("SELECT pc.*, user.firstname, user.lastname FROM product_comment pc INNER JOIN user "
                . "ON user.id=pc.user_id WHERE pc.id=? ");
        $res = $stmp->execute([$commentId]);
        if ($res === false) {
            var_dump($stmp->errorInfo());
            exit();
        }
        return $stmp->fetch(PDO::FETCH_ASSOC);
    }

    function getAll($productId) {
        $stmp = Db::getPdo()->prepare("SELECT pc.*, user.firstname, user.lastname FROM product_comment pc INNER JOIN user "
                . "ON user.id=pc.user_id WHERE product_id=? AND status='approved'");
        $res = $stmp->execute([$productId]);
        if ($res === false) {
            var_dump($stmp->errorInfo());
        }
        return $stmp->fetchAll(PDO::FETCH_ASSOC);
    }

    function posScore($commentId, $userId) {
        $this->saveScore($commentId, $userId, 1);
    }

    function negScore($commentId, $userId) {
        $this->saveScore($commentId, $userId, -1);
    }

    private function saveScore($commentId, $userId, $score) {
        $stmp = Db::getPdo()->prepare("REPLACE INTO product_comment_score SET user_id=:userId, comment_id=:commentId, score=:score");
        $res = $stmp->execute(["commentId" => $commentId, "userId" => $userId, "score" => $score]);
        if ($res === false) {
            var_dump($stmp->errorInfo());
            exit;
        }
        $stmp = Db::getPdo()->prepare("UPDATE product_comment SET "
                . "pos=(SELECT COUNT(*) FROM product_comment_score WHERE comment_id=:commentId AND score>0), "
                . "neg=(SELECT COUNT(*) FROM product_comment_score WHERE comment_id=:commentId AND score<0) "
                . "WHERE id=:commentId");

        $res = $stmp->execute(["commentId" => $commentId]);
        if ($res === false) {
            var_dump($stmp->errorInfo());
            exit;
        }
    }

}
