<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function autoLogin() {
    $_SESSION['loggedin'] = true;
}

function logout() {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>