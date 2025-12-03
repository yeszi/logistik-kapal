<?php
include 'db.php'; // Pastikan file db.php ada dan berisi koneksi $conn

// Query untuk mengambil data ulasan, diurutkan dari yang terbaru
$query = "SELECT id, nama, email, ulasan, created_at FROM ulasan_pengguna ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pengguna - Admin</title>
    <link rel="stylesheet" href="data_kapal_admin.css"> 
    <link rel="stylesheet" href="ulasan_admin.css"> <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="header"><h1>Ocean Information</h1><div class="admin-profile"><div class="profile-icon">A</div><span>ADMIN</span></div></div>
            <nav class="nav-menu">
                <a href="data_kapal_admin.php">🏠 Home</a>
                <a href="data_kapal_edit_admin.php">🚢 Tambah Kapal</a>
                <a href="data_kapal_admin2.php">✏️ Edit data kapal</a>
                <a href="ulasan_admin.php" class="active">💬 Ulasan</a>
                <a href="login_admin.php" class="logout">🚪 Logout</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="breadcrumb">
                <span>Admin</span><span class="separator">|</span><span>Ulasan Pengguna</span>
            </div>
            <div class="content-header">
                <h2>Daftar Ulasan Pengguna</h2>
            </div>

            <div class="ulasan-list">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="ulasan-card">
                            <div class="ulasan-header">
                                <span class="nama"><?php echo htmlspecialchars($row['nama']); ?></span>
                                <span class="email"><?php echo htmlspecialchars($row['email']); ?></span>
                                <span class="tanggal"><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></span>
                            </div>
                            <div class="ulasan-body">
                                <p><?php echo nl2br(htmlspecialchars($row['ulasan'])); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-data">Belum ada ulasan yang masuk.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>