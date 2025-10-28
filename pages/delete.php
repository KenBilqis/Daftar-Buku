<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: index.php?error=1');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header('Location: index.php?success=dihapus');
} catch (Exception $e) {
    header('Location: index.php?error=1');
}
exit;
?>