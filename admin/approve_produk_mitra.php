<?php
require '../service/connection.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_admin.php'); // Arahkan ke login admin jika bukan admin
    exit();
}

// Ambil daftar produk yang statusnya 'menunggu'
$stmt = $pdo->prepare("SELECT p.Id_Produk, p.Nama_Produk AS nama_produk, m.Nama_Toko, p.Harga, p.Status_Produk 
                       FROM produk p 
                       JOIN mitra m ON p.Id_Mitra = m.Id_Mitra 
                       WHERE p.Status_Produk = 'menunggu'");
$stmt->execute();
$products_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Produk</title>
    <link rel="stylesheet" href="../assets/css/approve.css"> <!-- Pastikan path CSS benar -->
</head>
<body>
    <h1>Daftar Produk Menunggu Persetujuan</h1>

    <!-- Tampilkan pesan sukses atau error -->
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php elseif (isset($_GET['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Nama Mitra</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products_list as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['Id_Produk']); ?></td>
                <td><?php echo htmlspecialchars($product['nama_produk']); ?></td>
                <td><?php echo htmlspecialchars($product['Nama_Toko']); ?></td>
                <td>Rp <?php echo number_format($product['Harga'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($product['Status_Produk']); ?></td>
                <td>
                    <a href="approve_produk_action.php?id=<?php echo $product['Id_Produk']; ?>&action=approve">Setujui</a>
                    <a href="approve_produk_action.php?id=<?php echo $product['Id_Produk']; ?>&action=reject">Tolak</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
