<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data produk yang dimiliki oleh mitra yang sedang login dan statusnya terkonfirmasi
$stmt = $pdo->prepare("SELECT * FROM produk WHERE Id_Mitra = ? ");
$stmt->execute([$user_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

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
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Kelola Produk</h1>
        <table>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['Id_Produk']); ?></td>
                    <td><?php echo htmlspecialchars($product['Nama_Produk']); ?></td>
                    <td>Rp <?php echo number_format($product['Harga'], 0, ',', '.'); ?></td>
                    <td><?php echo htmlspecialchars($product['Status_Produk']); ?></td>
                    <td>
                        <a href="update_order_status.php?id=<?php echo $pesanan['Id_Pesanan']; ?>">Ubah Status</a>
                        <a href="edit_produk.php?id=<?php echo $product['Id_Produk']; ?>">Edit</a> |
                        <a href="delete_produk.php?id=<?php echo $product['Id_Produk']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada produk yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
