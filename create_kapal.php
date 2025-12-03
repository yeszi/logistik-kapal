<?php
include('db.php');

if (isset($_POST['submit'])) {
    $nama_kapal = $_POST['nama_kapal'];
    $jenis_kapal = $_POST['jenis_kapal'];
    $tahun_dibangun = $_POST['tahun_dibangun'];
    $kapasitas = $_POST['kapasitas'];

    $sql = "INSERT INTO kapal (nama_kapal, jenis_kapal, tahun_dibangun, kapasitas)
            VALUES ('$nama_kapal', '$jenis_kapal', $tahun_dibangun, $kapasitas)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data kapal berhasil ditambahkan!";
        header("Location: data_kapal_admin.php"); // Redirect ke halaman data kapal admin
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kapal</title>
    <link rel="stylesheet" href="create_kapal.css">
</head>
<body>
    <h1>Tambah Data Kapal</h1>
    <form method="POST">
        <label for="nama_kapal">Nama Kapal</label>
        <input type="text" name="nama_kapal" required><br>
        
        <label for="jenis_kapal">Jenis Kapal</label>
        <input type="text" name="jenis_kapal" required><br>

        <label for="tahun_dibangun">Tahun Dibangun</label>
        <input type="number" name="tahun_dibangun" required><br>

        <label for="kapasitas">Kapasitas</label>
        <input type="number" name="kapasitas" required><br>

        <button type="submit" name="submit">Tambah Data</button>
    </form>
</body>
</html>

<?php $conn->close(); ?>
