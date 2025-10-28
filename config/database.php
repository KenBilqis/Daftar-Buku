<?php
// config/database.php
try {
    $host = 'localhost';
    $dbname = 'book_tracker';
    $username = 'root';       // sesuaikan dengan user MySQL Anda
    $password = '';           // sesuaikan (kosong untuk XAMPP default)

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: Terjadi kesalahan sistem.");
}
?>