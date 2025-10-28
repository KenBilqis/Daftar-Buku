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
    die("Terjadi kesalahan saat mengambil data.");
}
?>

<h2>Detail Buku</h2>
<p><strong>Judul:</strong> <?= htmlspecialchars($book['title']) ?></p>
<p><strong>Penulis:</strong> <?= htmlspecialchars($book['author']) ?></p>
<p><strong>Ringkasan:</strong><br><?= nl2br(htmlspecialchars($book['summary'])) ?></p>
<p><strong>Ditambahkan:</strong> <?= htmlspecialchars($book['created_at']) ?></p>
<p><strong>Diupdate:</strong> <?= htmlspecialchars($book['updated_at']) ?></p>

<a href="index.php" class="btn btn-primary">Kembali ke Daftar</a>

<?php require_once '../includes/footer.php'; ?>