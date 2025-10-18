<?php
// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit();
}
// Ambil username dari session untuk ditampilkan
$username = $_SESSION['username'] ?? 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-card {
            background-color: #ffffff;
            padding: 2.5rem 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .welcome-header {
            margin-bottom: 2.5rem;
        }
        .welcome-header h1 {
            font-weight: 300;
            font-size: 2.5rem;
        }
        .welcome-header h1 strong {
            font-weight: 600;
        }
        .action-buttons .btn {
            font-size: 1.1rem;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: none;
            color: white;
            transition: all 0.3s ease;
            margin: 0.5rem;
            width: 100%;
            max-width: 300px; /* Lebar tombol */
        }
        /* Hover effect */
        .action-buttons .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        /* Background colors */
        .btn-pendaftaran {
            background: linear-gradient(45deg, #4a00e0, #4918acff);
        }
        .btn-riwayat {
            background: linear-gradient(45deg, #5500ffff, #4a00e0);
        }
        .btn-logout {
            background: linear-gradient(45deg, #ec092fff, #b90725ff);
        }
    </style>
</head>
<body>
    <div class="dashboard-card">
        <div class="welcome-header">
            <h1>Selamat Datang, <strong><?= htmlspecialchars($username) ?></strong>!</h1><br>
            <p>Pilih aksi di bawah untuk melanjutkan.</p>
        </div>
        
        <div class="action-buttons">
            <div>
                <a href="index.php?action=formPendaftaran" class="btn btn-pendaftaran">Pendaftaran Pembalap</a>
            </div>
            <div>
                <a href="index.php?action=riwayatPendaftaran" class="btn btn-riwayat">Riwayat Pendaftaran</a>
            </div>
            <div>
                <a href="index.php?action=logout" class="btn btn-logout">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>

