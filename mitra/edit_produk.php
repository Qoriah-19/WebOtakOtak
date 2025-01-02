<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
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

$product_id = (int)$_GET['id']; // Pastikan ID produk adalah integer

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
    $nama_produk = htmlspecialchars(trim($_POST['nama']));
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];

    // Validasi data
    if (empty($nama_produk) || $harga <= 0 || $stok < 0) {
        $error = "Semua field wajib diisi dengan benar.";
    } else {
        // Perbarui data produk di database
        $stmt = $pdo->prepare("UPDATE produk SET Nama_Produk = ?, Harga = ?, Stok = ? WHERE Id_Produk = ? AND Id_Mitra = ?");
        if ($stmt->execute([$nama_produk, $harga, $stok, $product_id, $user_id])) {
            header('Location: manage_produk.php?message=Produk berhasil diperbarui.');
            exit();
        } else {
            $error = "Gagal memperbarui produk.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../assets/css/pemesanan.css">
    <!-- <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 200px;
            background-color: #007BFF;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
        }

        .content {
            margin-left: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style> -->
</head>
<body>
    
    <div class="content">
        <h1>Edit Produk</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="nama">Nama Produk:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($product['Nama_Produk'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($product['Harga'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($product['Stok'], ENT_QUOTES, 'UTF-8'); ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
