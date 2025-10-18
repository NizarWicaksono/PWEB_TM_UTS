<?php
class Pendaftaran {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    private function uploadFile($file) {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        $targetDir = "Public/";
        $fileName = uniqid() . '_' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName;
        } else {
            return null;
        }
    }

    public function create($postData, $files) {
        $namaFileLisensi = $this->uploadFile($files['foto_lisensi']);
        $jenisMobil = isset($postData['jenis_mobil']) ? implode(', ', $postData['jenis_mobil']) : '';

        $sql = "INSERT INTO pendaftaran (user_id, nama_lengkap, usia, provinsi, kota, alamat, kategori_balap, jenis_mobil, foto_lisensi_path, tanda_tangan_path) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $_SESSION['user_id'],
            $postData['nama_lengkap'],
            $postData['usia'],
            $postData['provinsi'],
            $postData['kota'],
            $postData['alamat'],
            $postData['kategori_balap'],
            $jenisMobil,
            $namaFileLisensi,
            $postData['tanda_tangan']
        ]);
    }

    public function getAll() {
        $sql = "SELECT p.*, u.username, prov.nama_provinsi, kota.nama_kota
                FROM pendaftaran p
                JOIN users u ON p.user_id = u.id
                LEFT JOIN provinsi prov ON p.provinsi = prov.id
                LEFT JOIN kota_kabupaten kota ON p.kota = kota.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT p.*, u.username, prov.nama_provinsi, kota.nama_kota
                FROM pendaftaran p
                JOIN users u ON p.user_id = u.id
                LEFT JOIN provinsi prov ON p.provinsi = prov.id
                LEFT JOIN kota_kabupaten kota ON p.kota = kota.id
                WHERE p.id = ?";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($postData, $files) {
        $pendaftaranId = $postData['pendaftaran_id'];
        $dataLama = $this->getById($pendaftaranId);
        $namaFileLisensi = $dataLama['foto_lisensi_path']; 

        if (isset($files['foto_lisensi']) && $files['foto_lisensi']['error'] === UPLOAD_ERR_OK) {
            $namaFileLisensi = $this->uploadFile($files['foto_lisensi']);
        }
        
        $jenisMobil = isset($postData['jenis_mobil']) ? implode(', ', $postData['jenis_mobil']) : '';
        
        $sql = "UPDATE pendaftaran SET 
                    nama_lengkap = ?, usia = ?, provinsi = ?, kota = ?, alamat = ?, 
                    kategori_balap = ?, jenis_mobil = ?, foto_lisensi_path = ?, tanda_tangan_path = ?
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
    
    public function delete($id, $userId) {
        $stmt = $this->pdo->prepare("SELECT foto_lisensi_path FROM pendaftaran WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        $pendaftaran = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pendaftaran) {
            $deleteStmt = $this->pdo->prepare("DELETE FROM pendaftaran WHERE id = ?");
            $deleteStmt->execute([$id]);

            if (!empty($pendaftaran['foto_lisensi_path'])) {
                $filePath = 'Public/' . $pendaftaran['foto_lisensi_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            return true;
        }
        return false;
    }
}
?>