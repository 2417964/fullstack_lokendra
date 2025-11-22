<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'functions.php';

requireLogin();

if (isset($_GET['logout'])) {
    logout();
}

$msg = '';
$msgType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $isbn = trim($_POST['isbn'] ?? '');
    
    if (addBook($mysqli, $title, $author, $genre, $year, $isbn)) {
        $msg = "Book added successfully!";
        // Clear form
        $_POST = [];
    } else {
        $msg = "Failed to add book.";
        $msgType = 'danger';
    }
}
?>