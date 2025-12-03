<?php
include('db.php'); // Menghubungkan ke database
$message = ''; // Variabel untuk menyimpan pesan notifikasi

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan data dari form
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $ulasan = trim($_POST['ulasan']);

    // 1. Validasi kolom tidak boleh kosong
    if (!empty($nama) && !empty($email) && !empty($ulasan)) {
        
        // 2. Validasi format email yang benar (INI BAGIAN YANG DIPERBAIKI)
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Jika email valid, lanjutkan proses ke database
            $sql = "INSERT INTO ulasan_pengguna (nama, email, ulasan) VALUES (?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                // Bind variabel ke prepared statement
                $stmt->bind_param("sss", $nama, $email, $ulasan);
                
                // Eksekusi statement
                if ($stmt->execute()) {
                    $message = "Terima kasih! Ulasan Anda telah berhasil dikirim.";
                } else {
                    $message = "Error: Terjadi kesalahan saat mengirim ulasan Anda.";
                }
                // Tutup statement
                $stmt->close();
            } else {
                $message = "Error: Gagal menyiapkan query.";
            }
        } else {
            // Jika format email tidak valid
            $message = "Mohon masukkan format email yang valid (contoh: nama@domain.com).";
        }
    } else {
        // Jika ada kolom yang kosong
        $message = "Mohon lengkapi semua kolom.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Ocean Information</title>
    <link rel="stylesheet" href="tentang_kami_user.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;700&family=Inknut+Antiqua:wght@400&family=Poppins:wght@400&display=swap" rel="stylesheet">
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
                    <li><a href="data_kapal_user.php">Data Kapal</a></li>
                    <li><a href="#" class="active">Tentang Kami</a></li>
                </ul>
            </nav>
            <div class="header-icons"><a href="login_admin.php"><img src="assets/user_icon.png" alt="User" class="icon"></a></div>
        </div>
    </header>
    <main>
        <section class="contact-section">
            <div class="contact-info">
                <h2>Contact Info</h2>
                <p class="placeholder-text">Hubungi kami atau tinggalkan ulasan Anda melalui form di samping!</p>
                <address>
                    <p><strong>Alamat :</strong> Tanjungpinang, Kepulauan Riau, Indonesia</p>
                    <p><strong>Telepon :</strong> +62 812-3456-7890</p>
                    <p><strong>Email :</strong> OceanInformation@gmail.com</p>
                </address>
            </div>
            <div class="contact-form">
                <form method="POST" action="tentang_kami_user.php">
                    
                    <?php if (!empty($message)): ?>
                        <div class="notification"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="ulasan">Ulasan</label>
                        <textarea id="ulasan" name="ulasan" rows="8" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Kirim</button>
                </form>
            </div>
        </section>
        <h3 class="map-title">Lihat Tracking Kapal</h3>
        <h6 class="teks">Tekan Peta Berikut Untuk Melihat Lalu Lintas Kapal</h6>
        <section class="map-section">
            <a href="https://www.marinetraffic.com/" target="_blank">
                <img src="assets/map_indonesia.png" alt="Peta Lokasi" class="map-image">
            </a>
        </section>
    </main>
    <footer>
        <p>@Copyright</p>
    </footer>
</body>
</html>