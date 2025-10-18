<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=login');
    exit();
}

$isEditMode = isset($pendaftaran) && $pendaftaran;
$formAction = $isEditMode ? 'index.php?action=updatePendaftaran' : 'index.php?action=createPendaftaran';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEditMode ? 'Edit' : 'Formulir' ?> Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #6a11cb, #2575fc); padding: 40px 0; }
        .form-container { background-color: #ffffff; padding: 2.5rem; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .form-header { margin-bottom: 2rem; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2><?= $isEditMode ? 'Edit Data Pembalap' : 'Formulir Pendaftaran Pembalap' ?></h2>
                <p class="text-muted">Silakan isi data di bawah.</p>
            </div>
            
            <form id="formPembalap" action="<?= $formAction ?>" method="post" enctype="multipart/form-data">
                
                <?php if ($isEditMode): ?>
                    <input type="hidden" name="pendaftaran_id" value="<?= htmlspecialchars($pendaftaran['id']) ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($pendaftaran['nama_lengkap'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="usia" class="form-label">Usia</label>
                    <input type="number" class="form-control" id="usia" name="usia" value="<?= htmlspecialchars($pendaftaran['usia'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="provinsi" class="form-label">Asal Provinsi</label>
                    <select class="form-select" id="provinsi" name="provinsi" required>
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kota" class="form-label">Asal Kota/Kabupaten</label>
                    <select class="form-select" id="kota" name="kota" required disabled>
                        <option value="">-- Pilih Provinsi Dulu --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($pendaftaran['alamat'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori Balap</label>
                    <div>
                        <?php $kategori = $pendaftaran['kategori'] ?? ''; ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_balap" id="kategoriRookie" value="Rookie" <?= $kategori == 'Rookie' ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="kategoriRookie">Rookie</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_balap" id="kategoriAmateur" value="Amateur" <?= $kategori == 'Amateur' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="kategoriAmateur">Amateur</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kategori_balap" id="kategoriPro" value="Pro" <?= $kategori == 'Pro' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="kategoriPro">Pro</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Mobil</label>
                    <div>
                        <?php $jenisMobil = explode(', ', $pendaftaran['jenis_mobil'] ?? ''); ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="jenis_mobil[]" id="jenisSedan" value="Sedan" <?= in_array('Sedan', $jenisMobil) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="jenisSedan">Sedan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="jenis_mobil[]" id="jenisHatchback" value="Hatchback" <?= in_array('Hatchback', $jenisMobil) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="jenisHatchback">Hatchback</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="jenis_mobil[]" id="jenisSUV" value="SUV" <?= in_array('SUV', $jenisMobil) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="jenisSUV">SUV</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="foto_lisensi" class="form-label">Upload Foto Lisensi (JPG/PNG)</label>
                    <input class="form-control" type="file" id="foto_lisensi" name="foto_lisensi" accept="image/jpeg, image/png">
                    <?php if ($isEditMode && !empty($pendaftaran['foto_lisensi'])): ?>
                        <small class="form-text text-muted">File saat ini: <a href="Public/<?= htmlspecialchars($pendaftaran['foto_lisensi']) ?>" target="_blank">Lihat File</a>. Kosongkan jika tidak ingin mengubah.</small>
                    <?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="signature-canvas" class="form-label">Tanda Tangan</label>
                    <canvas id="signature-canvas" class="border rounded" style="width: 300px; height: 150px; cursor: crosshair;"></canvas>
                    <button type="button" id="clear-signature" class="btn btn-sm btn-outline-secondary mt-2">Hapus Tanda Tangan</button>
                    <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="index.php?action=dashboard" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><?= $isEditMode ? 'Update Pendaftaran' : 'Kirim Pendaftaran' ?></button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinsiSelect = document.getElementById('provinsi');
        const kotaSelect = document.getElementById('kota');
        
        const selectedProvinsiId = '<?= $pendaftaran['provinsi_id'] ?? '' ?>';
        const selectedKotaId = '<?= $pendaftaran['kota_id'] ?? '' ?>';

        fetch('index.php?action=getProvinsi')
            .then(response => response.json())
            .then(data => {
                data.forEach(provinsi => {
                    const option = new Option(provinsi.nama_provinsi, provinsi.id);
                    if (provinsi.id == selectedProvinsiId) {
                        option.selected = true; 
                    }
                    provinsiSelect.add(option);
                });
                if (selectedProvinsiId) {
                    provinsiSelect.dispatchEvent(new Event('change'));
                }
            });

        provinsiSelect.addEventListener('change', function() {
            const provinsiId = this.value;
            kotaSelect.innerHTML = '<option value="">-- Memuat Kota --</option>';
            kotaSelect.disabled = true;

            if (!provinsiId) {
                kotaSelect.innerHTML = '<option value="">-- Pilih Provinsi Dulu --</option>';
                return;
            }

            fetch(`index.php?action=getKota&provinsi_id=${provinsiId}`)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                    data.forEach(kota => {
                        const option = new Option(kota.nama_kota, kota.id);
                        if (kota.id == selectedKotaId) {
                            option.selected = true; 
                        }
                        kotaSelect.add(option);
                    });
                    kotaSelect.disabled = false;
                });
        });
        
        const canvas = document.getElementById('signature-canvas');
        const ctx = canvas.getContext('2d');
        let drawing = false;
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        
        <?php if ($isEditMode && !empty($pendaftaran['tanda_tangan'])): ?>
            const img = new Image();
            img.src = '<?= $pendaftaran['tanda_tangan'] ?>';
            img.onload = () => {
                ctx.drawImage(img, 0, 0);
            };
        <?php endif; ?>

        function getMousePos(canvas, evt) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
        }

        canvas.addEventListener('mousedown', (e) => {
            drawing = true;
            const pos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        });

        canvas.addEventListener('mouseup', () => { drawing = false; });

        canvas.addEventListener('mousemove', (e) => {
            if (!drawing) return;
            const pos = getMousePos(canvas, e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        });
        
        document.getElementById('clear-signature').addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('tanda_tangan').value = '';
        });

        document.getElementById('formPembalap').addEventListener('submit', function() {
            if (!isCanvasBlank(canvas)) {
                document.getElementById('tanda_tangan').value = canvas.toDataURL('image/png');
            }
        });

        function isCanvasBlank(canvas) {
            return !canvas.getContext('2d')
                .getImageData(0, 0, canvas.width, canvas.height).data
                .some(channel => channel !== 0);
        }
    });
    </script>
</body>
</html>