<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login sebagai mitra
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Mendapatkan ID pengguna yang login

// Ambil daftar transaksi milik pengguna tertentu dan urutkan berdasarkan tanggal
$stmt = $pdo->prepare("
    SELECT t.*, u.Nama AS user_name 
    FROM transaksi t 
    JOIN pengguna u ON t.Id_Pengguna = u.Id_Pengguna
    WHERE t.Id_Pengguna = ? 
    ORDER BY t.created_at DESC
");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll(); // Ambil semua transaksi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
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
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .actions .confirm {
            background-color: #4CAF50;
        }
        .actions .reject {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>Konfirmasi Pembayaran</h1>
    <?php if (count($transactions) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pengguna</th>
                    <th>Jumlah</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaction['Id_Transaksi']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['jumlah']); ?></td>
                    <td>
                        <?php if (!empty($transaction['bukti_pembayaran'])): ?>
                            <a href="../uploads/<?php echo htmlspecialchars($transaction['bukti_pembayaran']); ?>" target="_blank">Lihat Bukti</a>
                        <?php else: ?>
                            Tidak ada bukti pembayaran
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($transaction['status']); ?></td>
                    <td class="actions">
                        <a class="confirm" href="confirm_payment_action.php?id=<?php echo $transaction['Id_Transaksi']; ?>&action=confirm">Konfirmasi</a>
                        <a class="reject" href="confirm_payment_action.php?id=<?php echo $transaction['Id_Transaksi']; ?>&action=reject">Tolak</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada transaksi yang perlu dikonfirmasi.</p>
    <?php endif; ?>
</body>
</html>
