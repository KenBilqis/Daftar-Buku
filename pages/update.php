<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$summary = trim($_POST['summary'] ?? '');

if (!$id || !is_numeric($id) || empty($title) || empty($author)) {
    header('Location: edit.php?id=' . ($id ?? '') . '&error=1');
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE books SET title = :title, author = :author, summary = :summary WHERE id = :id");
    $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':author' => $author,
        ':summary' => $summary
    ]);
    header('Location: index.php?success=diperbarui');
} catch (Exception $e) {
    header('Location: edit.php?id=' . $id . '&error=1');
}
exit;
?>