<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'functions.php';

requireLogin();

header('Content-Type: application/json');

if (isset($_GET['term'])) {
    $titles = autocompleteSearch($mysqli, $_GET['term']);
    echo json_encode($titles);
} else {
    echo json_encode([]);
}
?>