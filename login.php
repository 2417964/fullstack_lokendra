<?php
require_once 'config.php';
require_once 'auth.php';

if (isset($_POST['enter'])) {
    autoLogin();
    header("Location: index.php");
    exit;
}

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sci-Fi Library - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-body">
    <div class="stars"></div>
    <div class="twinkling"></div>
    
    <div class="login-container">
        <div class="login-card">
            <div class="text-center mb-4">
                <div class="login-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                        <path d="M2 17l10 5 10-5"/>
                        <path d="M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <h1 class="login-title">Sci-Fi Library</h1>
                <p class="login-subtitle">5CS045 Coursework - Digital Collection</p>
            </div>
            
            <form method="post">
                <button type="submit" name="enter" class="btn-enter">
                    <span>Enter Library</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</body>
</html>