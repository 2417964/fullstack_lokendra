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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    if (deleteBook($mysqli, $id)) {
        $msg = "Book deleted successfully!";
    } else {
        $msg = "Failed to delete book.";
        $msgType = 'danger';
    }
}

$searchTerm = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';
$year = $_GET['year'] ?? '';

$scifi_books = searchBooks($mysqli, $searchTerm, $genre, $year);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sci-Fi Library - Collection</title>
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
            <a href="index.php" class="nav-item active">
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
            <h1><i class="fas fa-book-open"></i> Book Collection</h1>
            <a href="add.php" class="btn-add">
                <i class="fas fa-plus"></i> Add New Book
            </a>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-<?php echo $msgType; ?> alert-dismissible fade show">
                <?php echo htmlspecialchars($msg); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="search-panel">
            <form class="search-form" method="get">
                <div class="search-grid">
                    <div class="search-field">
                        <label><i class="fas fa-search"></i> Search Title/Author</label>
                        <div class="input-wrapper">
                            <input type="text" name="search" id="searchInput" 
                                   placeholder="Enter title or author..." 
                                   value="<?php echo htmlspecialchars($searchTerm); ?>">
                            <div id="suggestions" class="autocomplete-suggestions"></div>
                        </div>
                    </div>
                    
                    <div class="search-field">
                        <label><i class="fas fa-tag"></i> Genre</label>
                        <select name="genre">
                            <option value="">All Genres</option>
                            <option value="Sci-Fi" <?php if($genre === 'Sci-Fi') echo 'selected'; ?>>Sci-Fi</option>
                        </select>
                    </div>
                    
                    <div class="search-field">
                        <label><i class="fas fa-calendar"></i> Year</label>
                        <input type="number" name="year" placeholder="Publication year" 
                               value="<?php echo htmlspecialchars($year); ?>">
                    </div>
                    
                    <div class="search-actions">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="index.php" class="btn-clear">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="books-grid">
            <?php 
            $hasBooks = false;
            while($book = $scifi_books->fetch_assoc()): 
                $hasBooks = true;
            ?>
            <div class="book-card">
                <div class="book-cover">
                    <i class="fas fa-book"></i>
                </div>
                <div class="book-details">
                    <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="book-author">
                        <i class="fas fa-user"></i> 
                        <?php echo htmlspecialchars($book['author']); ?>
                    </p>
                    <div class="book-meta">
                        <span class="badge-genre">
                            <i class="fas fa-tag"></i> 
                            <?php echo htmlspecialchars($book['genre']); ?>
                        </span>
                        <span class="badge-year">
                            <i class="fas fa-calendar"></i> 
                            <?php echo htmlspecialchars($book['year']); ?>
                        </span>
                    </div>
                    <p class="book-isbn">
                        <i class="fas fa-barcode"></i> 
                        ISBN: <?php echo htmlspecialchars($book['isbn']); ?>
                    </p>
                </div>
                <div class="book-actions">
                    <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="post" style="display:inline;" 
                          onsubmit="return confirm('Are you sure you want to delete this book?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                        <button type="submit" class="btn-delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if(!$hasBooks): ?>
            <div class="no-books">
                <i class="fas fa-folder-open"></i>
                <h3>No books found</h3>
                <p>Try adjusting your search criteria or add a new book to the collection.</p>
                <a href="add.php" class="btn-add">
                    <i class="fas fa-plus"></i> Add Your First Book
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>