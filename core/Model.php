<?php

require_once __DIR__ . '/../config/database.php';

class Model
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }
}