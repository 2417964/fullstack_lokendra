<?php
function addBook($mysqli, $title, $author, $genre, $year, $isbn) {
    $stmt = $mysqli->prepare("INSERT INTO scifi_books (title, author, genre, year, isbn) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $title, $author, $genre, $year, $isbn);
    return $stmt->execute();
}

function updateBook($mysqli, $id, $title, $author, $genre, $year, $isbn) {
    $stmt = $mysqli->prepare("UPDATE scifi_books SET title=?, author=?, genre=?, year=?, isbn=? WHERE id=?");
    $stmt->bind_param("sssiii", $title, $author, $genre, $year, $isbn, $id);
    return $stmt->execute();
}

function deleteBook($mysqli, $id) {
    $stmt = $mysqli->prepare("DELETE FROM scifi_books WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getBookById($mysqli, $id) {
    $stmt = $mysqli->prepare("SELECT * FROM scifi_books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

?>