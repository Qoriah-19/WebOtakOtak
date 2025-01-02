<?php
require '../service/connection.php';
session_start();

// Validasi sesi: pastikan user_id dan role admin tersedia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_admin.php'); // Redirect ke login admin jika sesi tidak valid
    exit();
}

// Ambil daftar mitra yang sudah bergabung dan produk yang mereka tawarkan
$stmt = $pdo->prepare("SELECT m.Id_Mitra, m.Nama_Mitra, m.Email_Mitra, m.Status_Mitra, 
                               p.Nama_Produk, p.Harga 
                        FROM mitra m 
                        LEFT JOIN produk p ON m.Id_Mitra = p.Id_Mitra 
                        WHERE m.Status_Mitra = 'disetujui' 
                        ORDER BY m.Id_Mitra");
$stmt->execute();
$mitra_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Mitra dan Produk</title>
    <link rel="stylesheet" href="../assets/css/approve.css">
</head>
<body>
    <h1>Laporan Mitra dan Produk</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID Mitra</th>
                <th>Nama Mitra</th>
                <th>Email Mitra</th>
                <th>Status Mitra</th>
                <th>Nama Produk</th>
                <th>Harga Produk</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($mitra_list)): ?>
                <tr>
                    <td colspan="6">Tidak ada mitra yang terdaftar.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($mitra_list as $mitra): ?>
                <tr>
                    <td><?php echo htmlspecialchars($mitra['Id_Mitra']); ?></td>
                    <td><?php echo htmlspecialchars($mitra['Nama_Mitra']); ?></td>
                    <td><?php echo htmlspecialchars($mitra['Email_Mitra']); ?></td>
                    <td><?php echo htmlspecialchars($mitra['Status_Mitra']); ?></td>
                    <td><?php echo htmlspecialchars($mitra['Nama_Produk'] ? $mitra['Nama_Produk'] : 'Tidak ada produk'); ?></td>
                    <td><?php echo $mitra['Harga'] ? 'Rp ' . number_format($mitra['Harga'], 0, ',', '.') : 'N/A'; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
