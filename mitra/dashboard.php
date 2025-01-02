<?php
require '../service/connection.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data mitra berdasarkan user_id
$stmt = $pdo->prepare("SELECT * FROM mitra WHERE Id_Mitra = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Cek status mitra
if ($user['Status_Mitra'] !== 'disetujui') {
    session_destroy();
    header('Location: auth/login_mitra.php?error=Akun Anda belum terkonfirmasi.');
    exit();
}

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menggunakan nama yang konsisten
    $name = htmlspecialchars(trim($_POST['Nama']));
    $description = htmlspecialchars(trim($_POST['Deskripsi']));
    $price = (int)$_POST['Harga'];
    $stock = (int)$_POST['Stok'];

    // Validasi input
    if (empty($name) || empty($description) || $price <= 0 || $stock < 0) {
        $error = "Semua field wajib diisi dengan benar.";
    } else {
        // Proses upload foto
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["Foto_Produk"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowed_types)) {
            if ($_FILES["Foto_Produk"]["size"] <= 2 * 1024 * 1024) { // Maksimum ukuran file: 2MB
                if (move_uploaded_file($_FILES["Foto_Produk"]["tmp_name"], $target_file)) {
                    // Simpan data ke database
                    $stmt = $pdo->prepare("INSERT INTO produk (Id_Mitra, Nama_Produk, Foto_Produk, Deskripsi, Harga, Stok, Status_Produk) VALUES (?, ?, ?, ?, ?, ?, 'menunggu')");
                    if ($stmt->execute([$user_id, $name, $file_name, $description, $price, $stock])) {
                        $success = "Produk berhasil diunggah dan menunggu persetujuan.";
                    } else {
                        $error = "Gagal menyimpan produk ke database.";
                    }
                } else {
                    $error = "Gagal mengunggah file. Silakan coba lagi.";
                }
            } else {
                $error = "Ukuran file terlalu besar. Maksimum 2MB.";
            }
        } else {
            $error = "Format file tidak valid. Gunakan JPG, JPEG, atau PNG.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/pemesanan.css">
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <ul>
            <li><a href="manage_produk.php">Kelola Produk</a></li>
            <li><a href="confirm_payment.php">Konfirmasi Pembayaran</a></li>
            <li><a href="Laporan_Penjualan.php">Laporan Payment</a></li>
            <li><a href="edit_profile.php">Edit Profil</a></li>
            <li><a href="../auth/logout.php?role=mitra">Logout</a></li>
        </ul>
    </nav>
    
    <div class="upload-text">Unggah Produk Anda di Sini!</div>

    <div class="form-container">
        <form action="dashboard.php" method="post" enctype="multipart/form-data">
            <label for="Nama">Nama Produk:</label>
            <input type="text" id="Nama" name="Nama" placeholder="Nama Produk" required>

            <label for="Foto_Produk">Foto Produk:</label>
            <input type="file" id="Foto_Produk" name="Foto_Produk" accept="image/*" required>

            <label for="Deskripsi">Deskripsi:</label>
            <textarea id="Deskripsi" name="Deskripsi" placeholder="Deskripsi Produk" required></textarea>

            <label for="Harga">Harga:</label>
            <input type="number" id="Harga" name="Harga" placeholder="Harga" required>

            <label for="Stok">Stok:</label>
            <input type="number" id="Stok" name="Stok" placeholder="Stok" required>

            <?php if (isset($success)): ?>
                <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php elseif (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <button type="submit">Unggah</button>
        </form>
    </div>
</body>
</html>
