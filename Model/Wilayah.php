<?php
class Wilayah {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllProvinsi() {
        $stmt = $this->pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKotaByProvinsiId($provinsiId) {
        $stmt = $this->pdo->prepare("SELECT * FROM kota_kabupaten WHERE provinsi_id = ? ORDER BY nama_kota ASC");
        $stmt->execute([$provinsiId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>