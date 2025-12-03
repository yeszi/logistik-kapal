<?php
include('db.php');

$kapal = null;
$error_message = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM kapal WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $kapal = $result->fetch_assoc();
    } else {
        $error_message = "Data kapal dengan ID tersebut tidak ditemukan.";
    }
    $stmt->close();
} else {
    $error_message = "ID Kapal tidak disediakan.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kapal - <?php echo $kapal ? htmlspecialchars($kapal['nama_kapal']) : 'Error'; ?></title>
    <link rel="stylesheet" href="detail_data_kapal_admin.css"> 
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
                <a href="data_kapal_admin2.php">✏️ Edit data kapal</a>
                <a href="ulasan_admin.php">💬 Ulasan</a> 
                <a href="login_admin.php" class="logout">🚪 Logout</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="breadcrumb">
                 <span>Admin</span><span class="separator">|</span><a href="data_kapal_admin2.php">Manajemen Kapal</a><span class="separator">|</span><span>Detail</span>
            </div>
            <div class="content-header">
                <h2>Detail Kapal</h2>
            </div>

            <?php if ($kapal): ?>
                <div class="detail-container">
                    <div class="detail-image-panel" style="background-image: url('<?php echo !empty($kapal['gambar_kapal']) ? htmlspecialchars($kapal['gambar_kapal']) : 'assets/placeholder-ship-1.jpg'; ?>');">
                         <?php if (empty($kapal['gambar_kapal'])): ?>
                            <div class="no-image-overlay">Gambar tidak tersedia</div>
                        <?php endif; ?>
                    </div>

                    <div class="detail-info-panel">
                        <div class="info-header">
                            <h3><?php echo htmlspecialchars($kapal['nama_kapal']); ?></h3>
                            <span>ID Kapal: <?php echo $kapal['id']; ?></span>
                        </div>
                        <div class="info-body">
                            <h4>Informasi Umum</h4>
                            <div class="info-grid">
                                <div class="info-label">Jenis Kapal</div>
                                <div class="info-value"><?php echo htmlspecialchars($kapal['jenis_kapal']); ?></div>

                                <div class="info-label">Tahun Dibangun</div>
                                <div class="info-value"><?php echo $kapal['tahun_dibangun']; ?></div>

                                <div class="info-label">Kapasitas</div>
                                <div class="info-value"><?php echo number_format($kapal['kapasitas']); ?> Ton</div>
                            </div>
                            
                            <hr class="info-divider">
                            
                            <h4>Informasi Jadwal</h4>
                             <div class="info-grid">
                                <div class="info-label">Jadwal Keberangkatan</div>
                                <div class="info-value">
                                    <?php echo $kapal['jadwal_keberangkatan'] ? date('d F Y, H:i', strtotime($kapal['jadwal_keberangkatan'])) : 'Belum dijadwalkan'; ?>
                                </div>

                                <div class="info-label">Pelabuhan Asal</div>
                                <div class="info-value"><?php echo htmlspecialchars($kapal['pelabuhan_asal'] ?? 'Tidak ada data'); ?></div>

                                <div class="info-label">Pelabuhan Tujuan</div>
                                <div class="info-value"><?php echo htmlspecialchars($kapal['pelabuhan_tujuan'] ?? 'Tidak ada data'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="action-footer">
                    <a href="data_kapal_admin2.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Manajemen
                    </a>
                </div>
            <?php else: ?>
                <div class="error-container">
                    <p><?php echo $error_message; ?></p>
                    <a href="data_kapal_admin2.php" class="btn btn-back">Kembali</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>