<?php

class User
{
    private $pdo;

    public function __construct($pdo = null)
    {
        if ($pdo === null) {
            $db = new Database();
            $pdo = $db->connect();
        }
        $this->pdo = $pdo;
    }

    public static function getAll()
    {
        $db = new Database();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

