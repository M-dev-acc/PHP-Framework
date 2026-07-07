<?php

use Framework\Database;

include __DIR__ . '/src/Framework/Database.php';

$db = new Database(
    'mysql',
    [
        'host' => "localhost",
        'port' => 3306,
        'dbname' => 'basic_framework',
    ],
    'root',
    ''
);

$query = "SELECT * FROM products";
$stmt = $db->connection->query($query);
var_dump($stmt->fetchAll());
