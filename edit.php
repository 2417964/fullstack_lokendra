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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Book - Sci-Fi Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-rocket"></i>
            <h2>Sci-Fi Library</h2>
        </div>
        
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item">
                <i class="fas fa-list"></i>
                <span>All Books</span>
            </a>
            <a href="add.php" class="nav-item">
                <i class="fas fa-plus-circle"></i>
                <span>Add New Book</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="?logout=1" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="content-header">
            <h1><i class="fas fa-edit"></i> Edit Book</h1>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Collection
            </a>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-<?php echo $msgType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($msg); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post" class="book-form">
                <input type="hidden" name="action" value="edit">
                
                <div class="form-section">
                    <h3><i class="fas fa-book"></i> Book Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">
                                <i class="fas fa-heading"></i> Book Title *
                            </label>
                            <input type="text" id="title" name="title" 
                                   placeholder="Enter book title" 
                                   value="<?php echo htmlspecialchars($book['title']); ?>" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="author">
                                <i class="fas fa-user"></i> Author *
                            </label>
                            <input type="text" id="author" name="author" 
                                   placeholder="Enter author name" 
                                   value="<?php echo htmlspecialchars($book['author']); ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="genre">
                                <i class="fas fa-tag"></i> Genre *
                            </label>
                            <select id="genre" name="genre" required>
                                <option value="Sci-Fi" <?php if($book['genre'] === 'Sci-Fi') echo 'selected'; ?>>Sci-Fi</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="year">
                                <i class="fas fa-calendar"></i> Publication Year *
                            </label>
                            <input type="number" id="year" name="year" 
                                   placeholder="e.g., 2024" 
                                   min="1900" max="2100"
                                   value="<?php echo htmlspecialchars($book['year']); ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="isbn">
                                <i class="fas fa-barcode"></i> ISBN
                            </label>
                            <input type="text" id="isbn" name="isbn" 
                                   placeholder="Enter ISBN number" 
                                   value="<?php echo htmlspecialchars($book['isbn']); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Update Book
                    </button>
                    <a href="index.php" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>