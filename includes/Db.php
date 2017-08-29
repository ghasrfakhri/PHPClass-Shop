<?php

class Db {

    static private $instance;
    private $databaseName = "shop";
    private $databaseUsername = "root";
    private $databasePassword = "";
    private $pdo;

    private function __construct() {
        $this->pdo = new PDO("mysql:dbname=$this->databaseName"
                , $this->databaseUsername
                , $this->databasePassword);
    }

    /**
     * 
     * @return \Db
     */
    static public function getInstance() {
        if (null === self::$instance) {
            self::$instance = new Db;
        }
        return self::$instance;
    }

    /**
     * 
     * @return \PDO
     */
    static public function getPdo() {
        return self::getInstance()->pdo;
    }

}
