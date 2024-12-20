<?php
require '../service/connection.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Periksa apakah ID produk disediakan
if (!isset($_GET['id'])) {
    header('Location: manage_produk.php');
    exit();
}

$product_id = $_GET['id'];

// Ambil data produk berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM produk WHERE Id_Produk = ? AND Id_Mitra = ?");
$stmt->execute([$product_id, $user_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Periksa apakah produk ditemukan
if (!$product) {
    header('Location: manage_produk.php');
    exit();
}

// Proses pembaruan data produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Validasi data (tambahkan sesuai kebutuhan)

    // Perbarui data produk di database
    $stmt = $pdo->prepare("UPDATE produk SET nama = ?, harga = ?, Stok = ? WHERE Id_Produk = ? AND Id_Mitra = ?");
    $stmt->execute([$nama_produk, $harga, $stok, $product_id, $user_id]);

    header('Location: manage_produk.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard Mitra</h2>
        <ul>
            <li><a href="upload_produk.php">Unggah Produk</a></li>
            <li><a href="manage_produk.php">Kelola Produk</a></li>
            <li><a href="confirm_payment.php">Konfirmasi Pembayaran</a></li>
            <li><a href="edit_profile.php">Edit Profil</a></li>
            <li><a href="../auth/logout.php?role=mitra">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Edit Produk</h1>
        <form method="post">
            <label for="nama">Nama Produk:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($product['nama']); ?>" required><br>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($product['harga']); ?>" required><br>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($product['Stok']); ?>" required><br>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
