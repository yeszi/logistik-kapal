<?php
include('db.php');

// Daftar pelabuhan untuk dropdown
$pelabuhan_list = [
    "Sunda Kelapa Jakarta", "Tanjung Priok", "Tanjung Perak", "Tanjung Uban",
    "Harbour Bay", "Batam Center", "Patinban", "Belawan", "Punggur", "Kijang"
];

// Proses tambah data kapal
if (isset($_POST['tambah'])) {
    $nama_kapal = $_POST['nama_kapal'];
    $jenis_kapal = $_POST['jenis_kapal'];
    $tahun_dibangun = $_POST['tahun_dibangun'];
    $kapasitas = $_POST['kapasitas'];

    $jadwal_keberangkatan = !empty($_POST['jadwal_keberangkatan']) ? $_POST['jadwal_keberangkatan'] : NULL;
    $pelabuhan_asal = !empty($_POST['pelabuhan_asal']) ? $_POST['pelabuhan_asal'] : NULL;
    $pelabuhan_tujuan = !empty($_POST['pelabuhan_tujuan']) ? $_POST['pelabuhan_tujuan'] : NULL;

    // Server-side validation
    if ($pelabuhan_asal && $pelabuhan_tujuan && $pelabuhan_asal === $pelabuhan_tujuan) {
        $error_message = "Pelabuhan Asal dan Tujuan tidak boleh sama.";
    } else {
        $gambar_kapal = '';
        if (isset($_FILES['gambar_kapal']) && $_FILES['gambar_kapal']['error'] == 0) {
            $target_dir = "assets/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $file_extension = strtolower(pathinfo($_FILES['gambar_kapal']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
                $target_file = $target_dir . $new_filename;
                if (move_uploaded_file($_FILES['gambar_kapal']['tmp_name'], $target_file)) {
                    $gambar_kapal = $target_file;
                } else {
                    $error_message = "Gagal mengupload gambar kapal!";
                }
            } else {
                $error_message = "Format file tidak diizinkan! Gunakan JPG, JPEG, PNG, atau GIF.";
            }
        }

        if (empty($nama_kapal) || empty($jenis_kapal) || empty($tahun_dibangun) || empty($kapasitas)) {
            $error_message = "Semua field bertanda * wajib diisi!";
        } else if (!isset($error_message)) {
            $insert_sql = "INSERT INTO kapal (nama_kapal, jenis_kapal, tahun_dibangun, kapasitas, gambar_kapal, jadwal_keberangkatan, pelabuhan_asal, pelabuhan_tujuan) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssiissss", $nama_kapal, $jenis_kapal, $tahun_dibangun, $kapasitas, $gambar_kapal, $jadwal_keberangkatan, $pelabuhan_asal, $pelabuhan_tujuan);

            if ($stmt->execute()) {
                echo "<script>alert('Data kapal berhasil ditambahkan!'); window.location='data_kapal_admin.php';</script>";
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kapal - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="data_kapal_edit_admin.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="header">
                <h1>Ocean Information</h1>
                <div class="admin-profile">
                    <div class="profile-icon">A</div>
                    <span>ADMIN</span>
                </div>
            </div>
            <nav class="nav-menu">
                <a href="data_kapal_admin.php">🏠 Home</a>
                <a href="data_kapal_edit_admin.php" class="active">🚢 Tambah Kapal</a>
                <a href="data_kapal_admin2.php">✏️ Edit data kapal</a>
                <a href="ulasan_admin.php">💬 Ulasan</a> 
                <a href="login_admin.php" class="logout">🚪 Logout</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="breadcrumb">
                <span>Admin</span><span class="separator">|</span><span>Tambah Data Kapal</span>
            </div>
            <div class="content-header">
                <h2>Tambah Data Kapal Baru</h2>
            </div>

            <div class="form-card">
                 <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Petunjuk:</strong> Field yang bertanda <span class="required">*</span> wajib diisi.
                </div>

                <form method="POST" enctype="multipart/form-data" id="tambahKapalForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_kapal">Nama Kapal <span class="required">*</span></label>
                            <input type="text" name="nama_kapal" id="nama_kapal" placeholder="Masukkan nama kapal" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kapal">Jenis Kapal <span class="required">*</span></label>
                            <select name="jenis_kapal" id="jenis_kapal" required>
                                <option value="">Pilih jenis kapal</option>
                                <option value="Kapal Penumpang">Kapal Penumpang</option>
                                <option value="Kapal Kargo">Kapal Kargo</option>
                                <option value="Kapal Tanker">Kapal Tanker</option>
                                <option value="Kapal Pesiar">Kapal Pesiar</option>
                                <option value="Kapal Perang">Kapal Perang</option>
                                <option value="Kapal Nelayan">Kapal Nelayan</option>
                                <option value="Kapal Kontainer">Kapal Kontainer</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tahun_dibangun">Tahun Dibangun <span class="required">*</span></label>
                            <input type="number" name="tahun_dibangun" id="tahun_dibangun" placeholder="Contoh: 2020" min="1800" max="<?= date('Y'); ?>" required>
                            <div class="help-text">Tahun antara 1800 - <?= date('Y'); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="kapasitas">Kapasitas (Ton/Unit) <span class="required">*</span></label>
                            <input type="number" name="kapasitas" id="kapasitas" placeholder="Jumlah kapasitas" min="1" required>
                            <div class="help-text">Kapasitas dalam satuan penumpang, ton, atau unit.</div>
                        </div>
                    </div>
                    
                    <h4 class="form-subtitle">Informasi Jadwal (Opsional)</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jadwal_keberangkatan">Jadwal Keberangkatan</label>
                            <input type="datetime-local" name="jadwal_keberangkatan" id="jadwal_keberangkatan">
                        </div>
                        <div class="form-group">
                            <label for="pelabuhan_asal">Pelabuhan Asal</label>
                            <select name="pelabuhan_asal" id="pelabuhan_asal">
                                <option value="">Pilih Pelabuhan Asal</option>
                                <?php foreach ($pelabuhan_list as $pelabuhan): ?>
                                    <option value="<?= htmlspecialchars($pelabuhan) ?>"><?= htmlspecialchars($pelabuhan) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="port-error" id="asal_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="pelabuhan_tujuan">Pelabuhan Tujuan</label>
                            <select name="pelabuhan_tujuan" id="pelabuhan_tujuan">
                                <option value="">Pilih Pelabuhan Tujuan</option>
                                <?php foreach ($pelabuhan_list as $pelabuhan): ?>
                                    <option value="<?= htmlspecialchars($pelabuhan) ?>"><?= htmlspecialchars($pelabuhan) ?></option>
                                <?php endforeach; ?>
                            </select>
                             <div class="port-error" id="tujuan_error"></div>
                        </div>
                    </div>

                    <h4 class="form-subtitle">Gambar Kapal (Opsional)</h4>
                    <div class="form-group">
                        <label for="gambar_kapal">Upload Gambar</label>
                        <input type="file" name="gambar_kapal" id="gambar_kapal" class="form-control-file" accept="image/*">
                        <div class="help-text">Format: JPG, JPEG, PNG, GIF (Max: 5MB)</div>
                    </div>

                    <div class="btn-container">
                        <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data Kapal</button>
                        <a href="data_kapal_admin.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('tambahKapalForm');
    const pelabuhanAsal = document.getElementById('pelabuhan_asal');
    const pelabuhanTujuan = document.getElementById('pelabuhan_tujuan');
    const asalError = document.getElementById('asal_error');
    const tujuanError = document.getElementById('tujuan_error');

    function validatePorts() {
        const asalValue = pelabuhanAsal.value;
        const tujuanValue = pelabuhanTujuan.value;
        let isValid = true;

        // Reset error states
        asalError.textContent = '';
        tujuanError.textContent = '';
        pelabuhanAsal.classList.remove('is-invalid');
        pelabuhanTujuan.classList.remove('is-invalid');

        if (asalValue && tujuanValue && asalValue === tujuanValue) {
            const errorMessage = 'Pelabuhan tidak boleh sama.';
            asalError.textContent = errorMessage;
            tujuanError.textContent = errorMessage;
            pelabuhanAsal.classList.add('is-invalid');
            pelabuhanTujuan.classList.add('is-invalid');
            isValid = false;
        }
        
        return isValid;
    }

    // Validate on change
    pelabuhanAsal.addEventListener('change', validatePorts);
    pelabuhanTujuan.addEventListener('change', validatePorts);

    // Validate on form submit
    form.addEventListener('submit', function(event) {
        if (!validatePorts()) {
            event.preventDefault(); // Mencegah form untuk dikirim jika validasi gagal
            alert('Terdapat kesalahan pada input. Mohon periksa kembali pelabuhan yang dipilih.');
        }
    });
});
</script>

</body>
</html>
<?php $conn->close(); ?>