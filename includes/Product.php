<?php

/**
 *
 * @author Administrator
 */
class Product {

    const STATUS_PUBLISH = 'publish';
    const STATUS_DRAFT = 'draft';
    const STATUS_REJECT = 'reject';

    /**
     * 
     * @global PDO $db
     * @param type $sku
     * @param type $title
     * @param type $description
     * @param type $price
     * @param type $quantity
     * @param type $status
     */
    function add($sku, $title, $description, $price, $quantity, $status) {
        $stmp = Db::getPdo()->prepare("INSERT INTO product SET sku=:sku, title=:title, description=:description, "
                . "price=:price, quantity=:quantity, status=:status");

        $res = $stmp->execute([
            "sku" => $sku,
            "title" => $title,
            "description" => $description,
            "price" => $price,
            "quantity" => $quantity,
            "status" => $status
        ]);
        if ($res == false) {
            var_dump($stmp->errorInfo());
        }

        return $db->lastInsertId();
    }

    function getAll() {
        $stmp = Db::getPdo()->prepare("SELECT id, title, price FROM product ");
        $res = $stmp->execute();
        return $stmp->fetchAll(PDO::FETCH_ASSOC);
    }
    function get($id) {
        $stmp = Db::getPdo()->prepare("SELECT id, title, price FROM product WHERE id=?");
        $res = $stmp->execute([$id]);
        return $stmp->fetch(PDO::FETCH_ASSOC);
    }
    
    

}
