<?php
require '../service/connection.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_user.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Id_Pengguna = ?");
$stmt->execute([$user_id]);
$pengguna = $stmt->fetch();

// Ambil semua produk dengan status 'terkonfirmasi' beserta data mitra
$stmt = $pdo->prepare("
    SELECT 
        p.Id_Produk, 
        p.Nama_Produk AS nama_produk, 
        p.Deskripsi AS deskripsi, 
        p.Harga AS harga, 
        p.Foto_Produk AS Foto_produk, 
        p.Stok AS stok, 
        m.Nama_Toko AS nama_toko 
    FROM produk p 
    JOIN mitra m ON p.Id_Mitra = m.Id_Mitra 
    WHERE p.Status_Produk = 'terkonfirmasi'
");
$stmt->execute();
$produk_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <ul>
            <li><a href="riwayat_pesanan.php">Riwayat Pesanan</a></li>
            <li><a href="edit_profile.php">Edit Profil</a></li>
            <li><a href="../auth/logout.php?role=pengguna">Logout</a></li>
        </ul>
    </nav>
    
    <main>
        <h1>Dashboard Pengguna</h1>
        <p>Selamat datang di dashboard pengguna Anda. Gunakan menu di sidebar untuk navigasi.</p>
        
        <h2>Daftar Produk</h2>
        <div class="produk-container">
            <?php if (count($produk_list) > 0): ?>
                <?php foreach ($produk_list as $produk): ?>
                    <div class="produk-card">
                        <img src="../uploads/<?php echo htmlspecialchars($produk['Foto_produk']); ?>" alt="Gambar <?php echo htmlspecialchars($produk['nama_produk']); ?>" class="produk-gambar">
                        <h2><?php echo htmlspecialchars($produk['nama_produk']); ?></h2>
                        <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($produk['deskripsi']); ?></p>
                        <p><strong>Harga:</strong> Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                        <p><strong>Stok:</strong> <?php echo htmlspecialchars($produk['stok']); ?></p>
                        <p><strong>Nama Mitra:</strong> <?php echo htmlspecialchars($produk['nama_toko']); ?></p>
                        <a href="pesan_produk.php?id=<?php echo $produk['Id_Produk']; ?>" class="btn-pesan">Pesan</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada produk yang tersedia saat ini.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        text-align: center;
    }
    h1, h2 {
        margin: 20px 0;
        color: #333;
    }
    .produk-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
    }
    .produk-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 300px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: left;
    }
    .produk-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
    .produk-card h2 {
        font-size: 18px;
        margin: 10px 0;
        color: #333;
    }
    .produk-card p {
        font-size: 14px;
        color: #555;
        margin: 5px 0;
    }
    .btn-pesan {
        display: inline-block;
        text-decoration: none;
        background-color: #007BFF;
        color: #fff;
        padding: 10px 15px;
        border-radius: 5px;
        margin-top: 10px;
        text-align: center;
    }
    .btn-pesan:hover {
        background-color: #0056b3;
    }
</style>
