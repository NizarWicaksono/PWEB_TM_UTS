<?php
// Memanggil model yang diperlukan
require_once 'Model/Pendaftaran.php';

class PendaftaranController {
    private $db;
    private $pendaftaranModel;

    public function __construct() {
        // Membuat koneksi database
        $this->db = require 'Config/database.php';
        // Membuat instance dari model Pendaftaran
        $this->pendaftaranModel = new Pendaftaran($this->db);
    }

    /**
     * Menampilkan halaman dashboard utama.
     */
    public function dashboard() {
        require 'View/Dashboard.php';
    }

    /**
     * Menampilkan formulir pendaftaran (kosong).
     */
    public function formPendaftaran() {
        require 'View/Form.php';
    }

    /**
     * Menampilkan halaman riwayat dengan semua data pendaftaran.
     */
    public function riwayatPendaftaran() {
        // Mengambil semua data dari model
        $semua_pendaftaran = $this->pendaftaranModel->getAllPendaftaran();
        // Memuat view dan mengirimkan data ke sana
        require 'View/RiwayatPendaftaran.php';
    }
    
    /**
     * Menampilkan detail satu pendaftaran berdasarkan ID.
     */
    public function detailPendaftaran() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pendaftaran = $this->pendaftaranModel->getPendaftaranById($id);
            if ($pendaftaran) {
                require 'View/DetailPendaftaran.php';
            } else {
                echo "Data pendaftaran tidak ditemukan.";
                // Sebaiknya arahkan ke halaman error atau riwayat
            }
        } else {
            // Jika tidak ada ID, arahkan kembali ke riwayat
            header('Location: index.php?action=riwayatPendaftaran');
            exit();
        }
    }

    /**
     * Menyiapkan form untuk mode edit dengan data yang sudah ada.
     */
    public function editPendaftaran() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pendaftaran = $this->pendaftaranModel->getPendaftaranById($id);
            
            // Keamanan: Pastikan hanya pemilik data yang bisa mengedit
            if ($pendaftaran && $pendaftaran['user_id'] == $_SESSION['user_id']) {
                // Variabel $pendaftaran akan tersedia di file form.php
                require 'View/Form.php';
            } else {
                // Jika mencoba mengedit data orang lain atau ID tidak valid
                echo "Akses ditolak atau data tidak ditemukan.";
                // Arahkan ke dashboard setelah beberapa detik atau beri tombol kembali
            }
        }
    }

    /**
     * Memproses dan menyimpan data pendaftaran baru ke database.
     */
    public function createPendaftaran() {
        // Pastikan request adalah POST untuk keamanan
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pendaftaranModel->create($_POST, $_FILES);
            // Arahkan kembali ke dashboard setelah berhasil untuk mencegah duplikasi data
            header('Location: index.php?action=dashboard');
            exit();
        }
    }

    /**
     * Memproses dan memperbarui data pendaftaran yang ada di database.
     */
    public function updatePendaftaran() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pendaftaranModel->update($_POST, $_FILES);
            // Arahkan kembali ke dashboard setelah berhasil
            header('Location: index.php?action=dashboard');
            exit();
        }
    }
}
?>

