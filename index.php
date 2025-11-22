<?php

require_once 'config.php';
require_once 'auth.php';
require_once 'functions.php';

requireLogin();

if (isset($_GET['logout'])) {
    logout();
}
?>