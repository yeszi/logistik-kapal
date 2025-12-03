<?php
include('db.php');

$row = null;
// --- PERBAIKAN KEAMANAN (Prepared Statements) ---
// Mendapatkan detail kapal berdasarkan ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // sanitasi ID
    $sql = "SELECT * FROM kapal WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kapal - Ocean Information</title>
    <link rel="stylesheet" href="detail_kapal_user.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;700&family=Inknut+Antiqua:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-top">
            <img src="assets/ocean-banner.png" alt="Logo Ocean Information" class="logo-img-top">
            <p class="tagline-text">" Samudra Lebih Dekat dengan Informasi Kapal Akurat! " 🌍 ⚓</p>
        </div>
        <div class="header-bottom">
            <div class="logo-container">
                <h1>Ocean Information</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="home_user.php">Home</a></li>
                    <li><a href="data_kapal_user.php" class="active">Data Kapal</a></li>
                    <li><a href="tentang_kami_user.php">Tentang Kami</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <img src="assets/search_icon.png" alt="Search" class="icon">
                <a href="login_admin.php">
                    <img src="assets/user_icon.png" alt="User" class="icon">
                </a>
            </div>
        </div>
    </header>

    <main>
        <?php if ($row): ?>
            <h2 class="page-title">Detail Kapal: <?php echo htmlspecialchars($row['nama_kapal']); ?></h2>

            <section class="ship-detail-content">
                <div class="ship-detail-image-column">
                    <img src="<?php echo !empty($row['gambar_kapal']) ? htmlspecialchars($row['gambar_kapal']) : 'assets/placeholder-ship-1.jpg'; ?>" alt="Foto Detail Kapal">
                </div>

                <div class="ship-detail-info-column">
                    <div class="info-section">
                        <h3>Informasi Umum Kapal</h3>
                        <p class="ship-info-text"><strong>Nama Kapal:</strong> <?php echo htmlspecialchars($row['nama_kapal']); ?></p>
                        <p class="ship-info-text"><strong>Nomor ID:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
                        <p class="ship-info-text"><strong>Tipe Kapal:</strong> <?php echo htmlspecialchars($row['jenis_kapal']); ?></p>
                    </div>

                    <div class="info-section">
                        <h3>Spesifikasi Teknis</h3>
                        <p class="ship-info-text"><strong>Kapasitas Muatan:</strong> <?php echo htmlspecialchars($row['kapasitas'] ?? '-'); ?> Ton</p>
                        <p class="ship-info-text"><strong>Tahun Dibangun:</strong> <?php echo htmlspecialchars($row['tahun_dibangun']); ?></p>
                    </div>

                    <div class="info-section">
                        <h3>Informasi Jadwal Pelayaran</h3>
                        <p class="ship-info-text"><strong>Jadwal Keberangkatan:</strong> 
                            <?php echo $row['jadwal_keberangkatan'] ? date('d M Y, H:i', strtotime($row['jadwal_keberangkatan'])) . ' WIB' : 'Belum ada jadwal'; ?>
                        </p>
                        <p class="ship-info-text"><strong>Pelabuhan Asal:</strong> <?php echo htmlspecialchars($row['pelabuhan_asal'] ?? 'N/A'); ?></p>
                        <p class="ship-info-text"><strong>Pelabuhan Tujuan:</strong> <?php echo htmlspecialchars($row['pelabuhan_tujuan'] ?? 'N/A'); ?></p>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <h2 class="page-title">Data Tidak Ditemukan</h2>
            <p style="text-align: center; padding: 50px;">Maaf, data kapal yang Anda cari tidak dapat ditemukan. Silakan kembali ke halaman sebelumnya.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Ocean Information</p>
    </footer>

</body>
</html>
<?php $conn->close(); ?>