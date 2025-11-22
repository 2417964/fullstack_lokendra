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

if ($mysqli->query("SELECT COUNT(*) as c FROM scifi_books")->fetch_assoc()['c'] == 0) {
    $scifi_books = [
        ["Dune", "Frank Herbert", "Sci-Fi", 1965, "9780441172719"],
        ["Foundation", "Isaac Asimov", "Sci-Fi", 1951, "9780553293357"],
        ["Neuromancer", "William Gibson", "Sci-Fi", 1984, "9780441569595"],
        ["The Left Hand of Darkness", "Ursula K. Le Guin", "Sci-Fi", 1969, "9780441478125"],
        ["Ender's Game", "Orson Scott Card", "Sci-Fi", 1985, "9780812550702"],
        ["Snow Crash", "Neal Stephenson", "Sci-Fi", 1992, "9780553380958"],
        ["The Martian", "Andy Weir", "Sci-Fi", 2011, "9780553418026"],
        ["Hyperion", "Dan Simmons", "Sci-Fi", 1989, "9780553283686"],
        ["The Three-Body Problem", "Liu Cixin", "Sci-Fi", 2008, "9780765382030"],
        ["Starship Troopers", "Robert Heinlein", "Sci-Fi", 1959, "9780441783588"],
        ["The Expanse: Leviathan Wakes", "James S.A. Corey", "Sci-Fi", 2011, "9780316129084"],
        ["Ready Player One", "Ernest Cline", "Sci-Fi", 2011, "9780307887443"],
        ["2001: A Space Odyssey", "Arthur C. Clarke", "Sci-Fi", 1968, "9780451457998"],
        ["Do Androids Dream of Electric Sheep?", "Philip K. Dick", "Sci-Fi", 1968, "9780345404473"],
        ["The Hitchhiker's Guide to the Galaxy", "Douglas Adams", "Sci-Fi", 1979, "9780345391803"]
    ];
    
    $stmt = $mysqli->prepare("INSERT INTO scifi_books (title, author, genre, year, isbn) VALUES (?, ?, ?, ?, ?)");
    foreach ($scifi_books as $b) {
        $stmt->bind_param("sssii", $b[0], $b[1], $b[2], $b[3], $b[4]);
        $stmt->execute();
    }
}
?>