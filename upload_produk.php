<?php
require '../service/connection.php';
session_start();

// Pastikan pengguna login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; // Pastikan 'user_id' sudah di-set di sesi login
    $name = htmlspecialchars($_POST['nama']);
    $description = htmlspecialchars($_POST['deskripsi']);
    $price = (int)$_POST['harga'];
    $stock = (int)$_POST['stok'];

    // Validasi input
    if (empty($name) || empty($description) || $price <= 0 || $stock <= 0) {
        $error = "Semua field wajib diisi dengan benar.";
    } else {
        // Proses upload foto
        $target_dir = "../uploads/";
        $file_name = time() . "_" . basename($_FILES["Foto_produk"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowed_types)) {
            if ($_FILES["Foto_produk"]["size"] <= 2 * 1024 * 1024) { // Maksimum ukuran file: 2MB
                if (move_uploaded_file($_FILES["Foto_produk"]["tmp_name"], $target_file)) {
                    // Simpan data ke database
                    $stmt = $pdo->prepare("INSERT INTO produk (id_mitra, nama, Foto_produk, deskripsi, harga, stok) VALUES (?, ?, ?, ?, ?, ?)");
                    if ($stmt->execute([$user_id, $name, $file_name, $description, $price, $stock])) {
                        header('Location: dashboard.php?message=Produk berhasil diunggah.');
                        exit();
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
    <title>Unggah Produk</title>
    <link rel="stylesheet" href="../assets/css/upload.css">
</head>
<body>
    <form action="upload_produk.php" method="post" enctype="multipart/form-data">
        <h1>Unggah Produk</h1>
        <label for="nama">Nama Produk:</label>
        <input type="text" id="nama" name="nama" placeholder="Nama Produk" required>

        <label for="Foto_produk">Foto Produk:</label>
        <input type="file" id="Foto_produk" name="Foto_produk" accept="image/*" required>

        <label for="deskripsi">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi Produk" required></textarea>

        <label for="harga">Harga:</label>
        <input type="number" id="harga" name="harga" placeholder="Harga" required>

        <label for="stok">Stok:</label>
        <input type="number" id="stok" name="stok" placeholder="Stok" required>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <button type="submit">Unggah</button>
    </form>
</body>
</html>