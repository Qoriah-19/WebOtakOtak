<?php
require '../service/connection.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                        $success = "Produk berhasil diunggah.";
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        nav {
            width: 100%;
            background-color: #007BFF;
            padding: 15px 0;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #FFD700;
        }

        h1 {
            margin-top: 30px;
            font-size: 32px;
            color: #333;
        }

        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 500px;
            margin: 20px;
            text-align: center;
        }

        .form-container h2 {
            font-size: 24px;
            color: #007BFF;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input, textarea, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            color: #555;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 12px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success {
            color: green;
            margin-top: 10px;
            font-weight: bold;
        }

        .error {
            color: red;
            margin-top: 10px;
            font-weight: bold;
        }

        .upload-text {
            margin: 20px;
            font-size: 18px;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            
            <li><a href="manage_produk.php">Kelola Produk</a></li>
            <li><a href="confirm_payment.php">Konfirmasi Pembayaran</a></li>
            <li><a href="edit_profile.php">Edit Profil</a></li>
            <li><a href="../auth/logout.php?role=mitra">Logout</a></li>
        </ul>
    </nav>

    <h1>Dashboard Mitra</h1>

    <div class="upload-text">Unggah Produk Anda di Sini !</div>

    <div class="form-container">
        <form action="dashboard.php" method="post" enctype="multipart/form-data">
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
