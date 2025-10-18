<?php
// Pengaturan koneksi ke database Anda
$host = 'localhost';
$dbname = 'pembalap'; // Sesuaikan dengan nama database baru Anda
$user = 'root'; // User default untuk XAMPP
$pass = ''; // Password default untuk XAMPP (biasanya kosong)

try {
    // Membuat koneksi menggunakan PDO (PHP Data Objects)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // Mengatur agar PDO menampilkan error jika terjadi masalah, ini sangat membantu saat debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Jika koneksi gagal, hentikan program dan tampilkan pesan error
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>