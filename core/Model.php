<?php

require_once DIR . '/../config/database.php';

class Model
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }
}