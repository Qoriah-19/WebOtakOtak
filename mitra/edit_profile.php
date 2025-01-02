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
    $name = trim($_POST['nama']);
    $nik = trim($_POST['nik']);
    $store_name = trim($_POST['nama_toko']);
    $address = trim($_POST['alamat']);
    $phone = trim($_POST['no_hp']);

    // Validasi input
    if (empty($name) || empty($nik) || empty($store_name) || empty($address) || empty($phone)) {
        $error = "Semua field harus diisi.";
    } else {
        // Update data mitra
        $stmt = $pdo->prepare("UPDATE mitra SET Nama_Mitra = ?, Nik = ?, Nama_Toko = ?, Alamat_Mitra = ?, No_Hp_Mitra = ? WHERE Id_Mitra = ?");
        if ($stmt->execute([$name, $nik, $store_name, $address, $phone, $user_id])) {
            // Redirect dengan pesan sukses
            header('Location: dashboard.php?message=Profil berhasil diperbarui.');
            exit();
        } else {
            $error = "Gagal memperbarui profil. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../assets/css/pemesanan.css">
</head>
<body>
    <form action="edit_profile.php" method="post">
        <h1>Edit Profil</h1>

        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mitra['Nama_Mitra'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="nik">NIK</label>
        <input type="text" id="nik" name="nik" value="<?php echo htmlspecialchars($mitra['Nik'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="nama_toko">Nama Toko</label>
        <input type="text" id="nama_toko" name="nama_toko" value="<?php echo htmlspecialchars($mitra['Nama_Toko'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($mitra['Alamat_Mitra'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        
        <label for="no_hp">No. HP</label>
        <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($mitra['No_Hp_Mitra'], ENT_QUOTES, 'UTF-8'); ?>" required>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        
        <button type="submit">Perbarui Profil</button>
    </form>
</body>
</html>
