<?php
$host = 'localhost'; // Ganti dengan host database Anda jika perlu
$username = 'root';  // Ganti dengan username database Anda
$password = '';      // Ganti dengan password database Anda
$dbname = 'logistik_db'; // Nama database yang telah Anda buat

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
