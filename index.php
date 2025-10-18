<?php
session_start();

$pdo = require_once 'Config/database.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'login':
    case 'register':
    case 'processRegister':
    case 'processLogin':
    case 'logout':
        require_once 'Controller/AuthController.php';
        $controller = new AuthController($pdo); 
        $controller->$action(); 
        break;

    case 'dashboard':
    case 'formPendaftaran':
    case 'createPendaftaran':
    case 'riwayatPendaftaran':
    case 'detailPendaftaran':
    case 'editPendaftaran':
    case 'updatePendaftaran':
    case 'deletePendaftaran': 
        require_once 'Controller/PendaftaranController.php';
        $controller = new PendaftaranController($pdo);
        $controller->$action();
        break;
    
    case 'getProvinsi':
    case 'getKota':
        require_once 'Controller/WilayahController.php';
        $controller = new WilayahController($pdo);
        $controller->$action();
        break;

    default:
        http_response_code(404); 
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        break;
}
?>