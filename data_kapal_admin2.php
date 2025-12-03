<?php
include('db.php');

// Daftar pelabuhan untuk dropdown
$pelabuhan_list = [
    "Sunda Kelapa Jakarta", "Tanjung Priok", "Tanjung Perak", "Tanjung Uban",
    "Harbour Bay", "Batam Center", "Patinban", "Belawan", "Punggur", "Kijang"
];

// Proses update data kapal
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_kapal = $_POST['nama_kapal'];
    $jenis_kapal = $_POST['jenis_kapal'];
    $tahun_dibangun = $_POST['tahun_dibangun'];
    $kapasitas = $_POST['kapasitas'];
    $jadwal_keberangkatan = !empty($_POST['jadwal_keberangkatan']) ? $_POST['jadwal_keberangkatan'] : NULL;
    $pelabuhan_asal = !empty($_POST['pelabuhan_asal']) ? $_POST['pelabuhan_asal'] : NULL;
    $pelabuhan_tujuan = !empty($_POST['pelabuhan_tujuan']) ? $_POST['pelabuhan_tujuan'] : NULL;

    $update_sql = "UPDATE kapal SET nama_kapal = ?, jenis_kapal = ?, tahun_dibangun = ?, kapasitas = ?, jadwal_keberangkatan = ?, pelabuhan_asal = ?, pelabuhan_tujuan = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssiisssi", $nama_kapal, $jenis_kapal, $tahun_dibangun, $kapasitas, $jadwal_keberangkatan, $pelabuhan_asal, $pelabuhan_tujuan, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Data kapal berhasil diupdate!'); window.location.href='data_kapal_admin2.php';</script>";
    } else {
        echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Proses penghapusan data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM kapal WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Data kapal berhasil dihapus!'); window.location.href='data_kapal_admin2.php';</script>";
    } else {
        echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Ambil data kapal
$sql = "SELECT * FROM kapal ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kapal - Admin</title>
    <link rel="stylesheet" href="data_kapal_admin2.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="header"><h1>Ocean Information</h1><div class="admin-profile"><div class="profile-icon">A</div><span>ADMIN</span></div></div>
            <nav class="nav-menu">
                <a href="data_kapal_admin.php">🏠 Home</a>
                <a href="data_kapal_edit_admin.php">🚢 Tambah Kapal</a>
                <a href="data_kapal_admin2.php" class="active">✏️ Edit data kapal</a>
                <a href="ulasan_admin.php">💬 Ulasan</a> 
                <a href="login_admin.php" class="logout">🚪 Logout</a>
            </nav>
        </div>
        
        <div class="main-content">
            <div class="breadcrumb">
                <span>Admin</span><span class="separator">|</span><span>Manajemen Data Kapal</span>
            </div>
            <div class="content-header">
                <h2>Manajemen Data Kapal</h2>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kapal</th>
                            <th>Jenis Kapal</th>
                            <th>Tahun</th>
                            <th>Kapasitas (Ton)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= htmlspecialchars($row['nama_kapal']); ?></td>
                                    <td><?= htmlspecialchars($row['jenis_kapal']); ?></td>
                                    <td><?= $row['tahun_dibangun']; ?></td>
                                    <td><?= number_format($row['kapasitas']); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn btn-edit" onclick="openEditModal(
                                                <?= $row['id']; ?>, 
                                                '<?= htmlspecialchars($row['nama_kapal'], ENT_QUOTES); ?>', 
                                                '<?= htmlspecialchars($row['jenis_kapal'], ENT_QUOTES); ?>', 
                                                <?= $row['tahun_dibangun']; ?>, 
                                                <?= $row['kapasitas']; ?>,
                                                '<?= htmlspecialchars($row['jadwal_keberangkatan'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['pelabuhan_asal'], ENT_QUOTES); ?>',
                                                '<?= htmlspecialchars($row['pelabuhan_tujuan'], ENT_QUOTES); ?>'
                                            )">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </button>
                                            <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Anda yakin ingin menghapus data kapal ini?')">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="no-data">Tidak ada data kapal tersedia.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Data Kapal</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form method="POST" id="editForm">
                <input type="hidden" name="id" id="editId">
                <div class="form-group"><label for="editNamaKapal">Nama Kapal</label><input type="text" name="nama_kapal" id="editNamaKapal" required></div>
                <div class="form-group"><label for="editJenisKapal">Jenis Kapal</label><input type="text" name="jenis_kapal" id="editJenisKapal" required></div>
                <div class="form-group"><label for="editTahunDibangun">Tahun Dibangun</label><input type="number" name="tahun_dibangun" id="editTahunDibangun" required></div>
                <div class="form-group"><label for="editKapasitas">Kapasitas</label><input type="number" name="kapasitas" id="editKapasitas" required></div>
                
                <h4 class="modal-subtitle">Edit Informasi Jadwal (Opsional)</h4>
                
                <div class="form-group"><label for="editJadwalKeberangkatan">Jadwal Keberangkatan</label><input type="datetime-local" name="jadwal_keberangkatan" id="editJadwalKeberangkatan"></div>
                <div class="form-group"><label for="editPelabuhanAsal">Pelabuhan Asal</label>
                    <select name="pelabuhan_asal" id="editPelabuhanAsal">
                        <option value="">Pilih Pelabuhan Asal</option>
                        <?php foreach ($pelabuhan_list as $pelabuhan): ?>
                            <option value="<?= htmlspecialchars($pelabuhan) ?>"><?= htmlspecialchars($pelabuhan) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group"><label for="editPelabuhanTujuan">Pelabuhan Tujuan</label>
                    <select name="pelabuhan_tujuan" id="editPelabuhanTujuan">
                        <option value="">Pilih Pelabuhan Tujuan</option>
                        <?php foreach ($pelabuhan_list as $pelabuhan): ?>
                            <option value="<?= htmlspecialchars($pelabuhan) ?>"><?= htmlspecialchars($pelabuhan) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="btn-container"><button type="submit" name="update" class="btn btn-update">Update Data</button><button type="button" class="btn btn-cancel" onclick="closeEditModal()">Batal</button></div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, namaKapal, jenisKapal, tahunDibangun, kapasitas, jadwal, asal, tujuan) {
            document.getElementById('editId').value = id;
            document.getElementById('editNamaKapal').value = namaKapal;
            document.getElementById('editJenisKapal').value = jenisKapal;
            document.getElementById('editTahunDibangun').value = tahunDibangun;
            document.getElementById('editKapasitas').value = kapasitas;
            
            if (jadwal) {
                document.getElementById('editJadwalKeberangkatan').value = jadwal.replace(' ', 'T');
            } else {
                document.getElementById('editJadwalKeberangkatan').value = '';
            }
            
            document.getElementById('editPelabuhanAsal').value = asal;
            document.getElementById('editPelabuhanTujuan').value = tujuan;
            
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>