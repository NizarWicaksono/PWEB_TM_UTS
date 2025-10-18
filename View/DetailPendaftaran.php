<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #6a11cb, #2575fc); padding: 40px 0; }
        .body-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }
        .detail-container { max-width: 800px; width:100%; background-color: #ffffff; padding: 0; border-radius: 15px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); overflow: hidden; }
        .detail-header { background: linear-gradient(to right, #6a11cb, #2575fc); color: white; padding: 1.5rem 2.5rem; }
        .detail-body { padding: 2.5rem; }
        .list-group-item { display: flex; justify-content: space-between; align-items: flex-start; }
        .list-group-item strong { color: #495057; min-width: 150px; }
        .data-value { text-align: right; word-break: break-word; }
        .data-image { max-width: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #fff; }
    </style>
</head>
<body>
    <div class="container body-container">
        <div class="detail-container">
            <div class="detail-header">
                <h1 class="mb-0 fs-3">Detail Pendaftaran</h1>
                <p class="mb-0">Rincian data untuk pembalap: <?= htmlspecialchars($pendaftaran['nama_lengkap']) ?></p>
            </div>
            
            <div class="detail-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nama Lengkap</strong><span class="data-value"><?= htmlspecialchars($pendaftaran['nama_lengkap']) ?></span></li>
                    <li class="list-group-item"><strong>Usia</strong><span class="data-value"><?= htmlspecialchars($pendaftaran['usia']) ?> tahun</span></li>
                    <li class="list-group-item"><strong>Provinsi</strong><span class="data-value"><?= htmlspecialchars($pendaftaran['nama_provinsi']) ?></span></li>
                    <li class="list-group-item"><strong>Kota/Kabupaten</strong><span class="data-value"><?= htmlspecialchars($pendaftaran['nama_kota']) ?></span></li>
                    <li class="list-group-item"><strong>Alamat</strong><span class="data-value"><?= nl2br(htmlspecialchars($pendaftaran['alamat'])) ?></span></li>
                    <li class="list-group-item"><strong>Kategori Balap</strong><span class="data-value"><?= htmlspecialchars($pendaftaran['kategori_balap']) ?></span></li>
                    <li class="list-group-item"><strong>Jenis Mobil</strong><span class="data-value"><?= htmlspecialchars($pendaftaran['jenis_mobil']) ?></span></li>
                    <li class="list-group-item">
                        <strong>Foto Lisensi</strong>
                        <span class="data-value">
                            <?php if (!empty($pendaftaran['foto_lisensi_path'])): ?>
                                <a href="Public/<?= htmlspecialchars($pendaftaran['foto_lisensi_path']) ?>" target="_blank">
                                    <img src="Public/<?= htmlspecialchars($pendaftaran['foto_lisensi_path']) ?>" alt="Foto Lisensi" class="data-image">
                                </a>
                            <?php else: ?>
                                Tidak diunggah
                            <?php endif; ?>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <strong>Tanda Tangan</strong>
                        <span class="data-value">
                            <?php if (!empty($pendaftaran['tanda_tangan_path'])): ?>
                                <img src="<?= htmlspecialchars($pendaftaran['tanda_tangan_path']) ?>" alt="Tanda Tangan" class="data-image">
                            <?php else: ?>
                                Tidak ada
                            <?php endif; ?>
                        </span>
                    </li>
                </ul>

                <div class="mt-4 text-center">
                    <a href="index.php?action=riwayatPendaftaran" class="btn btn-secondary">Kembali ke Riwayat</a>
                    <?php if ($pendaftaran['user_id'] == $_SESSION['user_id']): ?>
                        <a href="index.php?action=editPendaftaran&id=<?= $pendaftaran['id'] ?>" class="btn btn-warning">Edit Pendaftaran</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>