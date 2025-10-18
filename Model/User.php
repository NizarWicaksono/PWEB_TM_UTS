<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fungsi untuk membuat user baru (tanpa hashing password)
    public function create($username, $password) {
        // PERUBAHAN: Password sekarang disimpan langsung sebagai teks biasa
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        
        // Eksekusi query dengan password asli
        return $stmt->execute([$username, $password]);
    }

    // Fungsi untuk mencari user berdasarkan username
    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

