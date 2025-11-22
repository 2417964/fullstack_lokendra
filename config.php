<?php
define('DB_HOST', 'localhost');
define('DB_USER', '2417964');
define('DB_PASS', 'Qawsedrftgyh@!&2003');
define('DB_NAME', 'db2417964');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

?>