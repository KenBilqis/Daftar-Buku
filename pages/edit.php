<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID tidak valid.");
}

try {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$book) {
        die("Buku tidak ditemukan.");
    }
} catch (Exception $e) {
    die("Terjadi kesalahan.");
}
?>

<h2>Edit Buku</h2>

<form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?= $book['id'] ?>">

    <label>Judul Buku *</label>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

    <label>Penulis *</label>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

    <label>Ringkasan</label>
    <textarea name="summary"><?= htmlspecialchars($book['summary']) ?></textarea>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="index.php" class="btn btn-primary">Batal</a>
</form>

<?php require_once '../includes/footer.php'; ?>