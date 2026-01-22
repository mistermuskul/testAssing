<?php

try {
    $host = 'db';
    $dbname = 'testdb';
    $username = 'root';
    $password = 'rootpassword';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL successfully!";
    
    $stmt = $pdo->query("SELECT VERSION()");
    $version = $stmt->fetchColumn();
    echo "<br>MySQL Version: " . $version;
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
