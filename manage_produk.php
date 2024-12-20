<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data produk yang dimiliki oleh mitra yang sedang login
$stmt = $pdo->prepare("SELECT * FROM produk WHERE Id_Mitra = ?");
$stmt->execute([$user_id]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    
    <div class="content">
        <h1>Kelola Produk</h1>
        <table>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['Id_Produk']); ?></td>
                <td><?php echo htmlspecialchars($product['nama']); ?></td>
                <td>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></td>
                <td>
                    <a href="edit_produk.php?id=<?php echo $product['Id_Produk']; ?>">Edit</a> |
                    <a href="delete_produk.php?id=<?php echo $product['Id_Produk']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
