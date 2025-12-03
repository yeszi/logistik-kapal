<?php
include('db.php');

// Mengambil parameter pencarian
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Query untuk mengambil data kapal dengan fitur pencarian (Menggunakan Prepared Statements untuk keamanan)
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $sql = "SELECT * FROM kapal WHERE nama_kapal LIKE ? OR jenis_kapal LIKE ? OR tahun_dibangun LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
} else {
    $sql = "SELECT * FROM kapal";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kapal - Ocean Information</title>
    <link rel="stylesheet" href="data_kapal_user.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;700&family=Inknut+Antiqua:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* === CSS HEADER TERPUSAT (YANG SUDAH DIPERBAIKI) === */
        header {
            width: 100%;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-top {
            background-color: #D9E5F2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 50px;
            box-sizing: border-box;
            min-height: 60px;
        }

        .logo-img-top {
            height: 40px;
        }

        .tagline-text {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            color: #000;
        }

        .header-bottom {
            background-color: #0A2D50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 50px;
            height: 80px;
            box-sizing: border-box;
        }
        
        .logo-container {
            flex-shrink: 0; /* Mencegah logo menyusut */
        }
        
        .logo-container h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            color: white;
        }
        
        nav {
            flex-grow: 1; /* Membuat nav mengisi ruang kosong */
            display: flex;
            /* PERUBAHAN UTAMA: Menggeser menu ke kanan */
            justify-content: flex-end; 
            padding-right: 40px; /* Memberi jarak antara menu dan search bar */
        }
        
        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 40px; /* Jarak antar menu */
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            padding-bottom: 5px;
        }

        nav ul li a.active {
            border-bottom: 3px solid white;
        }
        
        .header-right {
            flex-shrink: 0; /* Mencegah sisi kanan menyusut */
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .header-search-form {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 20px;
            padding: 2px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        }
        
        .header-search-input {
            border: none;
            outline: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 18px;
            background: transparent;
            width: 180px;
        }
        
        .header-search-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 8px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .header-icons .icon {
            height: 24px;
            width: 24px;
            filter: brightness(0) invert(1);
        }

        /* === CSS untuk konten halaman (Search info, dll) === */
        .search-results-info {
            text-align: center;
            margin: 20px auto;
            max-width: 1200px;
            padding: 0 20px;
            color: #666;
            font-style: italic;
        }
        
        .clear-search {
            text-align: center;
            margin: 10px auto 30px;
        }
        
        .clear-search a {
            color: #667eea;
            text-decoration: none;
            padding: 8px 16px;
            border: 2px solid #667eea;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .clear-search a:hover {
            background: #667eea;
            color: white;
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            color: #888;
        }

        /* === CSS RESPONSIVE HEADER === */
        @media (max-width: 1024px) {
            .header-bottom { padding: 10px 30px; }
            nav { padding-right: 20px; }
            nav ul { gap: 30px; }
        }

        @media (max-width: 768px) {
            .header-top { flex-direction: column; text-align: center; gap: 10px; padding: 15px; }
            .logo-img-top { margin: 0; }
            .tagline-text { font-size: 16px; }

            .header-bottom { flex-wrap: wrap; height: auto; justify-content: center; gap: 15px; padding: 15px; }
            .logo-container { width: 100%; text-align: center; }
            nav { order: 2; padding: 0; justify-content: center; }
            .header-right { order: 1; }
        }
    </style>
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
                    <li><a href="#" class="active">Data Kapal</a></li>
                    <li><a href="tentang_kami_user.php">Tentang Kami</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <form method="GET" action="" class="header-search-form">
                    <input 
                        type="text" 
                        name="search" 
                        class="header-search-input" 
                        placeholder="Cari kapal..." 
                        value="<?php echo htmlspecialchars($search); ?>"
                    >
                    <button type="submit" class="header-search-button">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        Cari
                    </button>
                </form>
                <div class="header-icons">
                    <a href="login_admin.php">
                        <img src="assets/user_icon.png" alt="User" class="icon">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <h2 class="page-title">Data Kapal</h2>

        <?php if (!empty($search)): ?>
            <div class="search-results-info">
                <?php 
                $total_results = $result->num_rows;
                echo "Menampilkan {$total_results} hasil untuk pencarian: <strong>\"" . htmlspecialchars($search) . "\"</strong>";
                ?>
            </div>
            <div class="clear-search">
                <a href="data_kapal_user.php">Lihat Semua Kapal</a>
            </div>
        <?php endif; ?>

        <section class="ship-list">
            <?php
            if ($result->num_rows > 0) {
                $counter = 0;
                while($row = $result->fetch_assoc()) {
                    $counter++;
                    $reverseClass = ($counter % 2 == 0) ? 'ship-entry-reverse' : '';
                    
                    echo '<article class="ship-entry ' . $reverseClass . '">';
                    echo '<div class="ship-image-container">';
                    
                    $imageSrc = isset($row['gambar_kapal']) && !empty($row['gambar_kapal']) && file_exists($row['gambar_kapal'])
                        ? $row['gambar_kapal'] 
                        : 'assets/placeholder-ship-' . (($counter % 4) + 1) . '.jpg';
                    
                    echo '<img src="' . htmlspecialchars($imageSrc) . '" alt="Foto ' . htmlspecialchars($row['nama_kapal']) . '">';
                    echo '</div>';
                    echo '<div class="ship-details-container">';
                    echo '<h3>' . htmlspecialchars($row['nama_kapal']) . '</h3>';
                    echo '<p class="ship-info-text">Nama Kapal: ' . htmlspecialchars($row['nama_kapal']) . '</p>';
                    echo '<p class="ship-info-text">Tahun Dibangun: ' . htmlspecialchars($row['tahun_dibangun']) . '</p>';
                    
                    if (isset($row['jenis_kapal']) && !empty($row['jenis_kapal'])) {
                        echo '<p class="ship-info-text">Jenis: ' . htmlspecialchars($row['jenis_kapal']) . '</p>';
                    }
                    
                    if (isset($row['kapasitas']) && !empty($row['kapasitas'])) {
                        echo '<p class="ship-info-text">Kapasitas: ' . htmlspecialchars($row['kapasitas']) . ' ton</p>';
                    }
                    
                    echo '<a href="detail_kapal_user.php?id=' . $row['id'] . '" class="detail-button">Detail Kapal</a>';
                    echo '</div>';
                    echo '</article>';
                }
            } else {
                echo '<div class="no-results">';
                if (!empty($search)) {
                    echo '<p>Tidak ditemukan kapal yang sesuai dengan pencarian "<strong>' . htmlspecialchars($search) . '</strong>"</p>';
                    echo '<p>Silakan coba dengan kata kunci yang berbeda atau <a href="data_kapal_user.php">lihat semua kapal</a>.</p>';
                } else {
                    echo '<p class="no-data">Tidak ada data kapal yang tersedia.</p>';
                }
                echo '</div>';
            }
            ?>
        </section>
    </main>

    <footer>
        <p>@Copyright 2024 - Ocean Information</p> </footer>

    <script>
        // Script tidak perlu diubah, sudah cukup baik.
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.header-search-input');
            const searchForm = document.querySelector('.header-search-form');

            <?php if (!empty($search)): ?>
                searchInput.select(); // Lebih baik dari focus(), langsung select text
            <?php endif; ?>

            searchForm.addEventListener('submit', function(e) {
                if (searchInput.value.trim() === '') {
                    e.preventDefault();
                    searchInput.focus();
                }
            });
        });
    </script>

</body>
</html>
<?php 
$stmt->close();
$conn->close(); 
?>