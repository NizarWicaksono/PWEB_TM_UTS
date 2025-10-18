<?php
class Pendaftaran {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // --- FUNGSI UNTUK MENGURUS UPLOAD FILE ---
    private function uploadFile($file) {
        // Jika tidak ada file yang diupload atau terjadi error, kembalikan null
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $targetDir = "Public/"; // Folder tujuan
        // Membuat nama file yang unik untuk menghindari penimpaan file
        $fileName = uniqid() . '_' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        // Pindahkan file dari lokasi sementara ke folder Public
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName; // Kembalikan nama file jika berhasil
        } else {
            return null; // Kembalikan null jika gagal
        }
    }

    public function create($postData, $files) {
        // Proses upload foto lisensi
        $namaFileLisensi = $this->uploadFile($files['foto_lisensi']);

        // Menggabungkan pilihan checkbox menjadi satu string
        $jenisMobil = isset($postData['jenis_mobil']) ? implode(', ', $postData['jenis_mobil']) : '';

        $sql = "INSERT INTO pendaftaran (user_id, nama_lengkap, usia, provinsi_id, kota_id, alamat, kategori, jenis_mobil, foto_lisensi, tanda_tangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $_SESSION['user_id'], // Ambil user_id dari session
            $postData['nama_lengkap'],
            $postData['usia'],
            $postData['provinsi'], // Sesuaikan dengan 'name' di form
            $postData['kota'],     // Sesuaikan dengan 'name' di form
            $postData['alamat'],
            $postData['kategori_balap'], // Sesuaikan dengan 'name' di form
            $jenisMobil,
            $namaFileLisensi, // Gunakan nama file yang sudah di-upload
            $postData['tanda_tangan']
        ]);
    }

    public function getAll() {
        $sql = "SELECT p.*, u.username, pr.nama_provinsi, k.nama_kota 
                FROM pendaftaran p
                JOIN users u ON p.user_id = u.id
                JOIN provinsi pr ON p.provinsi_id = pr.id
                JOIN kota_kabupaten k ON p.kota_id = k.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT p.*, u.username, pr.nama_provinsi, k.nama_kota 
                FROM pendaftaran p
                JOIN users u ON p.user_id = u.id
                JOIN provinsi pr ON p.provinsi_id = pr.id
                JOIN kota_kabupaten k ON p.kota_id = k.id
                WHERE p.id = ?";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($postData, $files) {
        $pendaftaranId = $postData['pendaftaran_id'];
        
        // Ambil data lama untuk mengecek file foto
        $dataLama = $this->getById($pendaftaranId);
        $namaFileLisensi = $dataLama['foto_lisensi'];

        // Jika ada file baru yang diupload, proses upload dan ganti nama file lama
        if (isset($files['foto_lisensi']) && $files['foto_lisensi']['error'] === UPLOAD_ERR_OK) {
            $namaFileLisensi = $this->uploadFile($files['foto_lisensi']);
        }
        
        $jenisMobil = isset($postData['jenis_mobil']) ? implode(', ', $postData['jenis_mobil']) : '';
        
        $sql = "UPDATE pendaftaran SET 
                    nama_lengkap = ?, usia = ?, provinsi_id = ?, kota_id = ?, alamat = ?, 
                    kategori = ?, jenis_mobil = ?, foto_lisensi = ?, tanda_tangan = ?
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $postData['nama_lengkap'],
            $postData['usia'],
            $postData['provinsi'],
            $postData['kota'],
            $postData['alamat'],
            $postData['kategori_balap'],
            $jenisMobil,
            $namaFileLisensi,
            $postData['tanda_tangan'],
            $pendaftaranId
        ]);
    }
}
?>
