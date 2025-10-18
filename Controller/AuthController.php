<?php
require_once 'Model/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register() {
        require 'View/Register.php';
    }

    public function processRegister() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($password !== $confirmPassword) {
            echo "<script>alert('Konfirmasi password tidak cocok!'); window.location.href='index.php?action=register';</script>";
            return;
        }

        if ($this->userModel->findByUsername($username)) {
            echo "<script>alert('Username sudah digunakan!'); window.location.href='index.php?action=register';</script>";
            return;
        }

        if ($this->userModel->create($username, $password)) {
            echo "<script>alert('Akun berhasil dibuat! Silakan login.'); window.location.href='index.php?action=login';</script>";
        } else {
            echo "<script>alert('Registrasi gagal, coba lagi.'); window.location.href='index.php?action=register';</script>";
        }
    }

    public function login() {
        require 'View/Login.php';
    }

    public function processLogin() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->userModel->findByUsername($username);

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php?action=dashboard");
            exit();
        } else {
            echo "<script>alert('Username atau password salah!'); window.location.href='index.php?action=login';</script>";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}
?>