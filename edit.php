<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'functions.php';

requireLogin();

if (isset($_GET['logout'])) {
    logout();
}

$bookId = (int)($_GET['id'] ?? 0);
if (!$bookId) {
    header("Location: index.php");
    exit;
}

$book = getBookById($mysqli, $bookId);
if (!$book) {
    header("Location: index.php");
    exit;
}

$msg = '';
$msgType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $genre = trim($_POST['genre'] ?? '');
    $year = (int)($_POST['year'] ?? 0);
    $isbn = trim($_POST['isbn'] ?? '');
    
    if (updateBook($mysqli, $bookId, $title, $author, $genre, $year, $isbn)) {
        $msg = "Book updated successfully!";
        $book = getBookById($mysqli, $bookId);
    } else {
        $msg = "Failed to update book.";
        $msgType = 'danger';
    }
}
?>