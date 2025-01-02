<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_user.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Id_Pengguna = ?");
$stmt->execute([$user_id]);
$pengguna = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $address = trim($_POST['alamat']);
    $phone = trim($_POST['no_hp']);

    // Validasi input
    if (empty($name) || empty($email) || empty($address) || empty($phone)) {
        $error = "Semua field harus diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        // Update data pengguna
        $stmt = $pdo->prepare("UPDATE pengguna SET Nama_Pengguna = ?, Email_Pengguna = ?, Alamat_Pengguna = ?, No_Hp_Pengguna = ? WHERE Id_Pengguna = ?");
        if ($stmt->execute([$name, $email, $address, $phone, $user_id])) {
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
    <link rel="stylesheet" href="../assets/css/profile.css">
    
</head>
<body>
    <form action="edit_profile.php" method="post">
        <h1>Edit Profil</h1>
        
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pengguna['Nama_Pengguna'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pengguna['Email_Pengguna'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($pengguna['Alamat_Pengguna'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="no_hp">No. HP</label>
        <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pengguna['No_Hp_Pengguna'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <?php if (isset($error)): ?>
            <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <button type="submit">Perbarui Profil</button>
    </form>
</body>
</html>
