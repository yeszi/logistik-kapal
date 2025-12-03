<?php
include('db.php');

// Query untuk mengambil data kapal
$sql = "SELECT * FROM kapal";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kapal User</title>
    <link rel="stylesheet" href="./data_kapal_user.css">
</head>
<body>
    <h1>Data Kapal (User)</h1>

    <table>
        <thead>
            <tr>
                <th>ID Kapal</th>
                <th>Nama Kapal</th>
                <th>Jenis Kapal</th>
                <th>Tahun Dibangun</th>
                <th>Kapasitas</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama_kapal']; ?></td>
                    <td><?php echo $row['jenis_kapal']; ?></td>
                    <td><?php echo $row['tahun_dibangun']; ?></td>
                    <td><?php echo $row['kapasitas']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php $conn->close(); ?>
