<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_user.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat pesanan yang sudah dikonfirmasi oleh mitra
$stmt = $pdo->prepare("
    SELECT t.*, p.nama AS nama_produk 
    FROM transaksi t 
    JOIN produk p ON t.Id_Produk = p.Id_Produk 
    WHERE t.Id_Pengguna = ? AND t.status = 'terkonfirmasi'
");
$stmt->execute([$user_id]);
$riwayat_pesanan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <!-- <link rel="stylesheet" href="assets/css/dashboard.css"> -->
</head>
<body>
    <h1>Riwayat Pesanan</h1>

    <?php if (count($riwayat_pesanan) > 0): ?>
        <table>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
            <?php foreach ($riwayat_pesanan as $pesanan): ?>
            <tr>
                <td><?php echo htmlspecialchars($pesanan['Id_Transaksi']); ?></td>
                <td><?php echo htmlspecialchars($pesanan['nama_produk']); ?></td>
                <td><?php echo htmlspecialchars($pesanan['jumlah']); ?></td>
                <td>Rp<?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?></td>

                <td><?php echo htmlspecialchars($pesanan['status']); ?></td>
                <td><?php echo htmlspecialchars($pesanan['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada pesanan yang dikonfirmasi.</p>
    <?php endif; ?>
</body>
</html>
<style>
/* Reset default styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    padding: 20px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
}

/* Styling table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 15px;
    text-align: left;
    font-size: 14px;
}

th {
    background-color: #007BFF;
    color: white;
    font-weight: 600;
}

td {
    background-color: #f9f9f9;
    border-bottom: 1px solid #ddd;
}

tr:hover td {
    background-color: #f1f1f1;
}

table tr:last-child td {
    border-bottom: none;
}

/* Empty state when no records are found */
.no-records {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 300px;
    font-size: 18px;
    color: #777;
    font-style: italic;
}

/* Responsive styling */
@media (max-width: 768px) {
    table {
        font-size: 12px;
    }

    th, td {
        padding: 12px;
    }
}

header {
    text-align: center;
    margin-bottom: 20px;
}

p {
    text-align: center;
    font-size: 16px;
    color: #888;
}
</style>
