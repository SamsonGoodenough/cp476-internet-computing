<?php

include __DIR__ . '/Helper/DotEnv.php';
(new DotEnv(__DIR__ . '/.env'))->load();

$host = 'db';
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');

// check the MySQL connection status
$conn = new mysqli($host, $user, $pass, 'test');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    print("Connected to MySQL server successfully!\n");
}