<?php
require_once '../config/database.php';
require_once '../includes/header.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchClause = '';
$params = [];

if ($search !== '') {
    $searchClause = "WHERE title LIKE :search OR author LIKE :search";
    $params[':search'] = "%$search%";
}

// Hitung total data
$countSql = "SELECT COUNT(*) FROM books $searchClause";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$totalPages = ceil($total / $limit);

// Ambil data
$sql = "SELECT id, title, author, created_at FROM books $searchClause ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Pesan Flash (opsional, bisa ditambahkan jika ingin) -->
<?php if (!empty($_GET['success'])): ?>
    <div class="alert alert-success">Data berhasil <?= htmlspecialchars($_GET['success']) ?>!</div>
<?php endif; ?>
<?php if (!empty($_GET['error'])): ?>
    <div class="alert alert-danger">Gagal memproses data.</div>
<?php endif; ?>

<!-- Form Pencarian -->
<form method="GET" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Cari judul atau penulis..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-search">Cari</button>
    <?php if ($search): ?>
        <a href="index.php" class="btn btn-warning">Reset</a>
    <?php endif; ?>
</form>

<!-- Tabel Buku -->
<?php if (count($books) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tanggal Ditambahkan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars($book['created_at']) ?></td>
                <td>
                    <a href="show.php?id=<?= $book['id'] ?>" class="btn btn-primary">Detail</a>
                    <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $book['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" 
               class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

<?php else: ?>
    <p>Tidak ada buku ditemukan.</p>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>