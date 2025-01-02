<?php
require '../service/connection.php';
session_start();

// Cek jika sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: ../mitra/dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['Nama']);
    $namaToko = trim($_POST['NamaToko']);
    $nik = trim($_POST['Nik']);
    $email = trim($_POST['Email']);
    $password = trim($_POST['Password']);
    $confirm_password = trim($_POST['confirm_password']);
    $alamat = trim($_POST['Alamat']);
    $no_hp = trim($_POST['No_hp']);
    
    // Proses upload foto toko
    $foto_toko = $_FILES['Foto_Toko'];
    $target_dir = "../uploads/";
    $file_name = time() . "_" . basename($foto_toko["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png'];

    // Validasi input kosong
    if (empty($nama) || empty($namaToko) || empty($nik) || empty($email) || empty($password) || empty($confirm_password) || empty($alamat) || empty($no_hp) || empty($foto_toko['name'])) {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } elseif (!in_array($imageFileType, $allowed_types)) {
        $error = "Format file tidak valid. Gunakan JPG, JPEG, atau PNG.";
    } elseif ($foto_toko["size"] > 2 * 1024 * 1024) { // Maksimum ukuran file: 2MB
        $error = "Ukuran file terlalu besar. Maksimum 2MB.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Cek apakah NIK atau email sudah ada
        $stmt = $pdo->prepare("SELECT * FROM mitra WHERE Nik = ? OR Email_Mitra = ?");
        $stmt->execute([$nik, $email]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "NIK atau Email sudah digunakan.";
        } else {
            // Upload foto toko
            if (move_uploaded_file($foto_toko["tmp_name"], $target_file)) {
                // Masukkan data mitra ke dalam database dengan status 'pending'
                $stmt = $pdo->prepare("INSERT INTO mitra (Nama_Mitra, Nama_Toko, Nik, Email_Mitra, Password_Mitra, Alamat_Mitra, No_Hp_Mitra, Foto_Toko, Status_Mitra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'menunggu')");
                if ($stmt->execute([$nama, $namaToko, $nik, $email, $hashed_password, $alamat, $no_hp, $file_name])) {
                    $success = "Registrasi sukses! Akun Anda sedang menunggu konfirmasi dari admin.";
                } else {
                    $error = "Pendaftaran gagal. Silakan coba lagi.";
                }
            } else {
                $error = "Gagal mengunggah foto toko. Silakan coba lagi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="register_mitra.php" method="post" enctype="multipart/form-data">
            <h1>Daftar Akun Mitra</h1>
            <input type="text" id="Nama" name="Nama" placeholder="Nama pengguna" value="<?= htmlspecialchars($nama ?? '') ?>" required>
            <input type="text" id="NamaToko" name="NamaToko" placeholder="Nama Toko" value="<?= htmlspecialchars($namaToko ?? '') ?>" required>
            <input type="text" id="Nik" name="Nik" placeholder="NIK" value="<?= htmlspecialchars($nik ?? '') ?>" required>
            <input type="email" id="Email" name="Email" placeholder="Email" value="<?= htmlspecialchars($email ?? '') ?>" required>
            <input type="password" id="Password" name="Password" placeholder="Password" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <input type="text" id="Alamat" name="Alamat" placeholder="Alamat" value="<?= htmlspecialchars($alamat ?? '') ?>" required>
            <input type="text" id="No_hp" name="No_hp" placeholder="No HP" value="<?= htmlspecialchars($no_hp ?? '') ?>" required>
            <input type="file" id="Foto_Toko" name="Foto_Toko" accept="image/*" required>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <p style="color: green;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
            <button type="submit" id="btn-auth">Daftar</button>
            <p>Sudah mempunyai akun? <a href="./login_mitra.php">Login Sekarang</a></p>
        </form>
    </main>
</body>
</html>
