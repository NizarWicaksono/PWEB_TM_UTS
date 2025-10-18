<?php
// Memulai sesi di paling atas. Ini wajib untuk semua fitur yang berhubungan dengan login.
session_start();

// Memuat file koneksi database agar bisa digunakan oleh semua controller
require_once 'Config/database.php';

// Menentukan halaman/aksi apa yang diminta oleh pengguna dari URL.
// Jika tidak ada aksi yang diminta ('action' kosong), maka defaultnya adalah 'login'.
$action = $_GET['action'] ?? 'login';

// Menggunakan switch case untuk memilih Controller mana yang akan bekerja
switch ($action) {
    // --- KASUS UNTUK OTENTIKASI (LOGIN & REGISTER) ---
    case 'login':
    case 'register':
    case 'processRegister':
    case 'processLogin':
    case 'logout':
        require_once 'Controller/AuthController.php';
        $controller = new AuthController($pdo); // Kirim koneksi PDO ke controller
        $controller->$action(); // Panggil method yang sesuai dengan nama aksi (misal: $controller->login())
        break;

    // --- KASUS UNTUK FITUR UTAMA (SETELAH LOGIN) ---
    case 'dashboard':
    case 'formPendaftaran':
    case 'createPendaftaran':
    case 'riwayatPendaftaran':
    case 'detailPendaftaran':
    case 'editPendaftaran':
    case 'updatePendaftaran':
        require_once 'Controller/PendaftaranController.php';
        $controller = new PendaftaranController($pdo);
        $controller->$action();
        break;
    
    // --- KASUS UNTUK API (CHAIN-COMBO AJAX) ---
    case 'getProvinsi':
    case 'getKota':
        require_once 'Controller/WilayahController.php';
        $controller = new WilayahController($pdo);
        $controller->$action();
        break;

    // Jika aksi tidak dikenali (misal: index.php?action=halamananeh), tampilkan pesan error
    default:
        http_response_code(404); // Memberi tahu browser bahwa halaman tidak ditemukan
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        break;
}
?>

