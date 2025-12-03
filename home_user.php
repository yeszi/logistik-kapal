<?php
include('db.php'); // Menghubungkan ke database

// 1. Query untuk mengambil SEMUA data kapal
$sql_all_ships = "SELECT id, nama_kapal, gambar_kapal FROM kapal ORDER BY id DESC";
$result_all_ships = $conn->query($sql_all_ships);

$kapal_list = [];
if ($result_all_ships->num_rows > 0) {
    while($row = $result_all_ships->fetch_assoc()) {
        $kapal_list[] = $row;
    }
}

// 2. Definisikan gambar untuk Hero Slider
$hero_images = [
    "assets/aria.jpg",
    "assets/testing.jpg",
    "assets/testing2.jpg",
    "assets/placeholder-ship-2.jpg"
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ocean Information</title>
    <link rel="stylesheet" href="home_user.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;700&family=Inknut+Antiqua:wght@400&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
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
                    <li><a href="#" class="active">Home</a></li> 
                    <li><a href="data_kapal_user.php">Data Kapal</a></li>
                    <li><a href="tentang_kami_user.php">Tentang Kami</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <a href="login_admin.php">
                    <img src="assets/user_icon.png" alt="User" class="icon">
                </a>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="hero-slider-wrapper">
            <?php foreach ($hero_images as $image_path): ?>
                <div class="hero-slide">
                    <img src="<?php echo htmlspecialchars($image_path); ?>" alt="Kapal Kargo Besar" class="hero-image">
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="ship-gallery">
        <div class="subtitle-container">
            <h2 class="section-subtitle">Terbaru</h2>
        </div>
        <div class="news-grid-wrapper">
            <div class="news-grid" id="ship-grid-container">
                </div>
        </div>

        <?php 
        // Tombol ini hanya akan muncul jika jumlah kapal lebih dari 4
        if (count($kapal_list) > 4): 
        ?>
            <div class="view-all-container">
                <a href="data_kapal_user.php" class="more-ships-btn">Lihat Selengkapnya →</a>
            </div>
        <?php endif; ?>
        </section>

    <footer>
        <p>@Copyright</p>
    </footer>

<script>
    // ... (Kode JavaScript Anda tidak berubah, biarkan seperti adanya) ...
document.addEventListener('DOMContentLoaded', function() {

    // --- LOGIC UNTUK HERO SLIDER (TANPA KONTROL MANUAL) ---
    const heroSlides = document.querySelectorAll('.hero-slide');
    let currentHeroIndex = 0;
    
    if (heroSlides.length > 0) { // Pastikan ada slide sebelum menjalankan logika
        function showHeroSlide(index) {
            heroSlides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
            currentHeroIndex = index;
        }

        function nextHero() {
            let newIndex = (currentHeroIndex + 1) % heroSlides.length;
            showHeroSlide(newIndex);
        }
        
        showHeroSlide(0);
        setInterval(nextHero, 5000);
    }


    // --- LOGIC UNTUK GALERI KAPAL ---
    const allShips = <?php echo json_encode($kapal_list); ?>;
    const gridContainer = document.getElementById('ship-grid-container');
    const shipsPerPage = 4;
    let currentGalleryPage = 0;

    function renderGalleryPage(page) {
        gridContainer.innerHTML = ''; 
        const startIndex = page * shipsPerPage;
        const endIndex = startIndex + shipsPerPage;
        const shipsToShow = allShips.slice(startIndex, endIndex);

        shipsToShow.forEach(ship => {
            const imageSrc = ship.gambar_kapal ? ship.gambar_kapal : 'assets/placeholder-ship-1.jpg';
            
            const card = document.createElement('div');
            card.className = 'news-card';
            card.innerHTML = `
                <img src="${imageSrc}" alt="${ship.nama_kapal}" onerror="this.onerror=null;this.src='assets/placeholder-ship-1.jpg';">
                <a href="detail_kapal_user.php?id=${ship.id}" class="view-detail-btn">Lihat Kapal</a>
            `;
            gridContainer.appendChild(card);
        });
    }

    if(allShips.length > 0) {
        renderGalleryPage(currentGalleryPage);
    } else {
        gridContainer.innerHTML = "<p>Tidak ada data kapal yang tersedia.</p>";
    }
});
</script>

</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>