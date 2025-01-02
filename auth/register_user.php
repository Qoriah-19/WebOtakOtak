<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error = ''; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nama = trim($_POST['Nama']);
    $Email = trim($_POST['Email']);
    $Password = $_POST['Password'];
    $confirm_password = $_POST['confirm_password'];
    $Alamat = trim($_POST['Alamat']);
    $No_Hp = trim($_POST['No_Hp']);

    // Validasi input
    if (empty($Nama) || empty($Email) || empty($Password) || empty($confirm_password) || empty($Alamat) || empty($No_Hp)) {
        $error = "Semua field harus diisi.";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif ($Password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok.";
    } else {
        // Cek apakah nama atau email sudah ada
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Nama_Pengguna = ? OR Email_Pengguna = ?");
        $stmt->execute([$Nama, $Email]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "Nama atau Email sudah digunakan.";
        } else {
            $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO pengguna (Nama_Pengguna, Email_Pengguna, Password_Pengguna, Alamat_Pengguna, No_Hp_Pengguna) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$Nama, $Email, $hashedPassword, $Alamat, $No_Hp])) {
                header('Location: ./login_user.php');
                exit();
            } else {
                $error = "Pendaftaran gagal. Silakan coba lagi.";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="register_user.php" method="post">
            <h1>Daftar Akun Pengguna</h1>
            <input type="text" id="Nama" name="Nama" placeholder="Nama pengguna" required>
            <input type="email" id="Email" name="Email" placeholder="Email" required>
            <input type="password" id="Password" name="Password" placeholder="Password" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <input type="text" id="Alamat" name="Alamat" placeholder="Alamat" required>
            <input type="text" id="No_Hp" name="No_Hp" placeholder="No Hp" required>
        
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <button type="submit" id="btn-auth">Daftar</button>
            <p>Sudah mempunyai akun? <a href="./login_user.php">Login Sekarang</a></p>
        </form>
    </main>
</body>
</html>
