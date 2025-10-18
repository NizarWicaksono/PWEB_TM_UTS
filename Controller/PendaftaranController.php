<?php
require_once 'Model/Pendaftaran.php';

class PendaftaranController {
    private $pendaftaranModel;

    public function __construct($pdo) {
        $this->pendaftaranModel = new Pendaftaran($pdo);
    }

    public function dashboard() {
        require 'View/Dashboard.php';
    }

    public function formPendaftaran() {
        require 'View/Form.php';
    }

    public function riwayatPendaftaran() {
        $semua_pendaftaran = $this->pendaftaranModel->getAll();
        require 'View/RiwayatPendaftaran.php';
    }
    
    public function detailPendaftaran() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pendaftaran = $this->pendaftaranModel->getById($id);
            if ($pendaftaran) {
                require 'View/DetailPendaftaran.php';
            } else {
                echo "Data pendaftaran tidak ditemukan.";
            }
        } else {
            header('Location: index.php?action=riwayatPendaftaran');
            exit();
        }
    }

    public function editPendaftaran() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pendaftaran = $this->pendaftaranModel->getById($id);
            
            if ($pendaftaran && $pendaftaran['user_id'] == $_SESSION['user_id']) {
                require 'View/Form.php';
            } else {
                echo "Akses ditolak atau data tidak ditemukan.";
            }
        }
    }

    public function createPendaftaran() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->pendaftaranModel->create($_POST, $_FILES)) {
                echo "<script>
                        alert('Pendaftaran berhasil dibuat!');
                        window.location.href = 'index.php?action=dashboard';
                      </script>";
            } else {
                echo "<script>
                        alert('Pendaftaran gagal, terjadi kesalahan.');
                        window.location.href = 'index.php?action=formPendaftaran';
                      </script>";
            }
            exit();
        }
    }

    public function updatePendaftaran() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->pendaftaranModel->update($_POST, $_FILES)) {
                echo "<script>
                        alert('Pendaftaran berhasil diperbarui!');
                        window.location.href = 'index.php?action=dashboard';
                      </script>";
            } else {
                echo "<script>
                        alert('Update gagal, terjadi kesalahan.');
                        window.location.href = 'index.php?action=riwayatPendaftaran';
                      </script>";
            }
            exit();
        }
    }

    public function deletePendaftaran() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit();
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $userId = $_SESSION['user_id'];
            
            $this->pendaftaranModel->delete($id, $userId);
        }
        header('Location: index.php?action=riwayatPendaftaran');
        exit();
    }
}
?>