<?php
session_start();
include('db.php'); // Pastikan file ini terhubung ke database 'logistik_db'

$error = ''; // Inisialisasi variabel error

// Cek jika ada request POST dari form dengan tombol bernama 'login'
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- PERBAIKAN KEAMANAN: GUNAKAN PREPARED STATEMENTS ---
    // Query untuk cek login dengan cara yang aman
    $sql = "SELECT * FROM admin WHERE username = ? AND password = ? AND role = 'admin'";
    
    // Siapkan statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    // Bind parameter ke statement (s = string)
    $stmt->bind_param("ss", $username, $password);
    
    // Eksekusi statement
    $stmt->execute();
    
    // Ambil hasilnya
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Jika data ditemukan (login berhasil)
        $_SESSION['username'] = $username;
        header("Location: data_kapal_admin.php"); // Redirect ke halaman admin
        exit(); // Penting: hentikan eksekusi script setelah redirect
    } else {
        // Jika data tidak ditemukan (login gagal)
        $error = "Username atau password salah!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ocean Information - Admin Login</title> <link rel="stylesheet" href="login_admin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <a href="home_user.php" class="back-btn">
      &larr; Kembali
    </a>
    <div class="login-box">
      <h1 class="title">Ocean Information</h1>
      <div class="image-circle"></div>

      <form method="post" action="">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
        </div>

        <?php
        // Menampilkan pesan error jika ada
        if (!empty($error)) {
            echo '<p style="color: red; text-align: center;">' . $error . '</p>';
        }
        ?>

        <button type="submit" name="login" class="signup-btn">Login</button> </form>

    </div>
  </div>
</body>
</html>

<?php $conn->close(); ?>