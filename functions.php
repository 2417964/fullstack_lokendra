<?php
function addBook($mysqli, $title, $author, $genre, $year, $isbn) {
    $stmt = $mysqli->prepare("INSERT INTO scifi_books (title, author, genre, year, isbn) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $title, $author, $genre, $year, $isbn);
    return $stmt->execute();
}

?>