<?php
require '../service/connection.php';
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data mitra dari database
$stmt = $pdo->prepare("SELECT * FROM mitra WHERE Id_Mitra = ?");
$stmt->execute([$user_id]);
$mitra = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['nama'];
    $nik = $_POST['nik'];
    $store_name = $_POST['nama_toko'];
    $address = $_POST['alamat'];
    $phone = $_POST['no_hp'];

    // Update data mitra
    $stmt = $pdo->prepare("UPDATE mitra SET nama = ?, nik = ?, nama_toko = ?, alamat = ?, no_hp = ? WHERE Id_Mitra = ?");
    if ($stmt->execute([$name, $nik, $store_name, $address, $phone, $user_id])) {
        // Redirect dengan pesan sukses
        header('Location: dashboard.php?message=Profil berhasil diperbarui.');
        exit();
    } else {
        $error = "Gagal memperbarui profil. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
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

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            resize: none;
            height: 80px;
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
    </style>
</head>
<body>
    <form action="edit_profile.php" method="post">
        <h1>Edit Profil</h1>

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mitra['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="nik">NIK</label>
        <input type="text" id="nik" name="nik" value="<?php echo htmlspecialchars($mitra['nik'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="nama_toko">Nama Toko</label>
        <input type="text" id="nama_toko" name="nama_toko" value="<?php echo htmlspecialchars($mitra['nama_toko'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($mitra['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        
        <label for="no_hp">No. HP</label>
        <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($mitra['no_hp'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        
        <button type="submit">Perbarui Profil</button>
    </form>
</body>
</html>
