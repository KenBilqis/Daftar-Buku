<?php
require_once '../includes/header.php';
?>

<h2>Tambah Buku Baru</h2>

<form method="POST" action="store.php">
    <label>Judul Buku *</label>
    <input type="text" name="title" required>

    <label>Penulis *</label>
    <input type="text" name="author" required>

    <label>Ringkasan</label>
    <textarea name="summary"></textarea>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="index.php" class="btn btn-primary">Batal</a>
</form>

<?php require_once '../includes/footer.php'; ?>