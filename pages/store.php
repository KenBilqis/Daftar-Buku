<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$summary = trim($_POST['summary'] ?? '');

// Validasi
if (empty($title) || empty($author)) {
    header('Location: create.php?error=1');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO books (title, author, summary) VALUES (:title, :author, :summary)");
    $stmt->execute([
        ':title' => $title,
        ':author' => $author,
        ':summary' => $summary
    ]);
    header('Location: index.php?success=ditambahkan');
} catch (Exception $e) {
    header('Location: create.php?error=1');
}
exit;
?>