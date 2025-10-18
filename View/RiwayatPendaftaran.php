<?php
// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit();
}

// Ambil ID pengguna yang sedang login untuk perbandingan
$current_user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #6a11cb, #2575fc); padding: 40px 0; color: #495057; }
        .container { max-width: 1000px; }
        .table-container { background-color: #ffffff; padding: 2rem; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .table-header { margin-bottom: 2rem; text-align: center; }
        .table thead { background-color: #f8f9fa; }
        .action-buttons a { margin-right: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <div class="table-header">
                <h2>Riwayat Pendaftaran Pembalap</h2>
                <p class="text-muted">Berikut adalah semua data pendaftaran yang telah masuk.</p>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembalap</th>
                            <th>Usia</th>
                            <th>Kategori</th>
                            <th>Asal Provinsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($semua_pendaftaran)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data pendaftaran.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($semua_pendaftaran as $index => $p): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                                    <td><?= htmlspecialchars($p['usia']) ?></td>
                                    <td><?= htmlspecialchars($p['kategori']) ?></td>
                                    <td><?= htmlspecialchars($p['nama_provinsi']) ?></td>
                                    <td class="action-buttons">
                                        <a href="index.php?action=detailPendaftaran&id=<?= $p['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                                        <?php if ($p['user_id'] == $current_user_id): ?>
                                            <a href="index.php?action=editPendaftaran&id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center">
                <a href="index.php?action=dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
