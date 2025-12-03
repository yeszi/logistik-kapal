<?php
// Koneksi database - sesuaikan dengan db.php Anda
include 'db.php'; // Pastikan file db.php ada dan berisi koneksi database

// Query untuk mengambil data kapal
$kapal_list = [];
$error_message = "";

// Coba beberapa kemungkinan variabel koneksi database
// Coba beberapa kemungkinan variabel koneksi database
if (isset($pdo)) {
    // Jika menggunakan PDO dengan variabel $pdo
    try {
        // --- UBAH BARIS INI ---
        $query = "SELECT id, nama_kapal, gambar_kapal FROM kapal ORDER BY nama_kapal ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $kapal_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "PDO Error: " . $e->getMessage();
    }
} elseif (isset($conn)) {
    // Jika menggunakan MySQLi dengan variabel $conn
    // --- UBAH BARIS INI ---
    $query = "SELECT id, nama_kapal, gambar_kapal FROM kapal ORDER BY nama_kapal ASC";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $kapal_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error_message = "MySQLi Error: " . mysqli_error($conn);
    }
} elseif (isset($connection)) {
    // Jika menggunakan MySQLi dengan variabel $connection
    // --- UBAH BARIS INI ---
    $query = "SELECT id, nama_kapal, gambar_kapal FROM kapal ORDER BY nama_kapal ASC";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $kapal_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error_message = "MySQLi Error: " . mysqli_error($connection);
    }
} else {
    // Jika tidak ada variabel koneksi yang dikenali
    $error_message = "Database connection not found. Please check your db.php file.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OceanInformation - Admin Beranda</title>
    <link rel="stylesheet" href="data_kapal_admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        
        .ship-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .no-image {
            width: 100%;
            height: 150px;
            background-color: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            margin-bottom: 10px;
        }
        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .no-data {
            text-align: center;
            color: #666;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="header">
                <h1>Ocean Information</h1>
                <div class="admin-profile">
                    <div class="profile-icon">A</div>
                    <span>ADMIN</span>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="#" class="active">🏠 Home</a>
                <a href="data_kapal_edit_admin.php">🚢 Tambah Kapal</a>
                <a href="data_kapal_admin2.php">✏️ Edit data kapal</a>
                <a href="ulasan_admin.php">💬 Ulasan</a> 
                <a href="login_admin.php" class="logout">🚪 Logout</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="breadcrumb">
                <span>Admin</span>
                <span class="separator">|</span>
                <span>Home</span>
            </div>

            <div class="content-header">
                <h2>List Data Kapal</h2>
            </div>

            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <div class="ship-list-container">
                <?php if (!empty($kapal_list)): ?>
                    <?php foreach ($kapal_list as $kapal): ?>
                        <div class="ship-list-item">
                            <?php if (!empty($kapal['gambar_kapal'])): ?>
                                <img src="<?php echo htmlspecialchars($kapal['gambar_kapal']); ?>" 
                                     alt="<?php echo htmlspecialchars($kapal['nama_kapal']); ?>" 
                                     class="ship-image">
                            <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-ship" style="font-size: 48px;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="ship-item-header">
                                <?php echo htmlspecialchars($kapal['nama_kapal']); ?>
                            </div>
                            <div class="ship-item-content">
                                <a href="detail_data_kapal_admin.php?id=<?php echo $kapal['id']; ?>" 
                                   class="view-detail-btn">Lihat Detail →</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-ship" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
                        <p>Tidak ada data kapal yang tersedia.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>