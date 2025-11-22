<?php
define('DB_HOST', 'localhost');
define('DB_USER', '2417964');
define('DB_PASS', 'Qawsedrftgyh@!&2003');
define('DB_NAME', 'db2417964');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME) or die($mysqli->error);
$mysqli->select_db(DB_NAME);

$table_sql = "CREATE TABLE IF NOT EXISTS scifi_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    year INT,
    isbn VARCHAR(20),
    added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$mysqli->query($table_sql);

?>