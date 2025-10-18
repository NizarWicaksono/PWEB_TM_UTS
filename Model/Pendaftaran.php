<?php
class Pendaftaran {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fungsi untuk menyimpan pendaftaran baru ke database
    public function create($data) {
        $sql = "INSERT INTO pendaftaran (user_id, nama_lengkap, usia, provinsi_id, kota_id, alamat, kategori, jenis_mobil, foto_lisensi, tanda_tangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Eksekusi query dengan data yang diterima
        return $stmt->execute([
            $data['user_id'],
            $data['nama_lengkap'],
            $data['usia'],
            $data['provinsi_id'],
            $data['kota_id'],
            $data['alamat'],
            $data['kategori'],
            $data['jenis_mobil'],
            $data['foto_lisensi'],
            $data['tanda_tangan']
        ]);
    }

    // Fungsi untuk mengambil semua data pendaftaran (untuk halaman riwayat)
    public function getAll() {
        // Query ini menggabungkan (JOIN) 4 tabel sekaligus untuk mendapatkan nama user, provinsi, dan kota
        $sql = "SELECT p.*, u.username, pr.nama_provinsi, k.nama_kota 
                FROM pendaftaran p
                JOIN users u ON p.user_id = u.id
                JOIN provinsi pr ON p.provinsi_id = pr.id
                JOIN kota_kabupaten k ON p.kota_id = k.id
                ORDER BY p.created_at DESC"; // Urutkan berdasarkan yang terbaru
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mengambil satu data pendaftaran berdasarkan ID-nya (untuk halaman detail dan edit)
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

    // Fungsi untuk memperbarui data pendaftaran di database
    public function update($id, $data) {
        $sql = "UPDATE pendaftaran SET 
                    nama_lengkap = ?, 
                    usia = ?, 
                    provinsi_id = ?, 
                    kota_id = ?, 
                    alamat = ?, 
                    kategori = ?, 
                    jenis_mobil = ?, 
                    foto_lisensi = ?, 
                    tanda_tangan = ?
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $data['nama_lengkap'],
            $data['usia'],
            $data['provinsi_id'],
            $data['kota_id'],
            $data['alamat'],
            $data['kategori'],
            $data['jenis_mobil'],
            $data['foto_lisensi'],
            $data['tanda_tangan'],
            $id
        ]);
    }
}
?>
