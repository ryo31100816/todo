<?php
require_once (__DIR__.'/../config/database.php');

class Bassmodel{
    public function __construct(){
        $this->dbConnect();
    }
    public function dbConnect(){
        return new PDO(DSN, USER, PASSWORD);
    }
}