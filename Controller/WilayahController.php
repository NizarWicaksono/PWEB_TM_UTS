<?php
// Memanggil model yang diperlukan
require_once 'Model/Wilayah.php';

class ApiController {

    private $db;
    private $wilayahModel;

    public function __construct() {
        // Membuat koneksi database
        $this->db = require 'Config/database.php';
        // Membuat instance dari model Wilayah
        $this->wilayahModel = new Wilayah($this->db);
    }

    /**
     * Mengambil dan menampilkan semua provinsi dalam format JSON.
     */
    public function getProvinsi() {
        // Mengatur header agar browser tahu ini adalah respons JSON
        header('Content-Type: application/json');
        
        $provinsi = $this->wilayahModel->getAllProvinsi();
        // Mengubah array PHP menjadi string JSON dan menampilkannya
        echo json_encode($provinsi);
    }

    /**
     * Mengambil dan menampilkan kota berdasarkan ID provinsi dalam format JSON.
     */
    public function getKota() {
        header('Content-Type: application/json');
        
        // Memastikan parameter provinsi_id ada di URL
        if (isset($_GET['provinsi_id'])) {
            $provinsi_id = $_GET['provinsi_id'];
            $kota = $this->wilayahModel->getKotaByProvinsiId($provinsi_id);
            echo json_encode($kota);
        } else {
            // Jika tidak ada parameter, kirim array kosong
            echo json_encode([]);
        }
    }
}
?>

