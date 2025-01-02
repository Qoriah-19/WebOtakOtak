<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login sebagai mitra
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

// Ambil daftar pengguna yang telah melakukan pembayaran yang disetujui
$stmt = $pdo->prepare("
    SELECT u.Id_Pengguna, u.Nama_Pengguna, u.Email_Pengguna, t.Id_Transaksi, t.Jumlah, t.Status_Pembayaran 
    FROM pengguna u 
    JOIN transaksi t ON u.Id_Pengguna = t.Id_Pengguna 
    ORDER BY t.created_at DESC
");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran Pengguna</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Laporan Pembayaran Pengguna</h1>
    <?php if (count($users) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pengguna</th>
                    <th>Nama Pengguna</th>
                    <th>Email Pengguna</th>
                    <th>ID Transaksi</th>
                    <th>Jumlah</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['Id_Pengguna']); ?></td>
                    <td><?php echo htmlspecialchars($user['Nama_Pengguna']); ?></td>
                    <td><?php echo htmlspecialchars($user['Email_Pengguna']); ?></td>
                    <td><?php echo htmlspecialchars($user['Id_Transaksi']); ?></td>
                    <td><?php echo number_format($user['Jumlah'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($user['Status_Pembayaran']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada pengguna dengan pembayaran yang disetujui.</p>
    <?php endif; ?>
</body>
</html>
