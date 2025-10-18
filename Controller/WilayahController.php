<?php
// Memanggil model yang diperlukan
require_once 'Model/Wilayah.php';

// NAMA CLASS DIPERBAIKI
class WilayahController {

    private $wilayahModel;

    // CONSTRUCTOR DIPERBAIKI: Menggunakan $pdo yang dikirim dari index.php
    public function __construct($pdo) {
        $this->wilayahModel = new Wilayah($pdo);
    }

    /**
     * Mengambil dan menampilkan semua provinsi dalam format JSON.
     */
    public function getProvinsi() {
        header('Content-Type: application/json');
        
        $provinsi = $this->wilayahModel->getAllProvinsi();
        echo json_encode($provinsi);
    }


    public function getKota() {
        header('Content-Type: application/json');
        
        if (isset($_GET['provinsi_id'])) {
            $provinsi_id = $_GET['provinsi_id'];
            $kota = $this->wilayahModel->getKotaByProvinsiId($provinsi_id);
            echo json_encode($kota);
        } else {
            echo json_encode([]);
        }
    }
}
?>