<?php

class Database{

    protected $pdo;

    /**
     * Create PDO connection
     */
    public function __construct(){
        try {
            $this->pdo = new PDO("mysql:host=localhost:8889;dbname=apicasier", "root", "root");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (\PDOException $e) {
            
            echo $e->getMessage();
        }
    }
}