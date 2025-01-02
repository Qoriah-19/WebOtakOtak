<?php
require '../service/connection.php';
session_start();

// Jika sudah login, langsung arahkan ke halaman dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: ../mitra/dashboard.php');
    exit();
}

// Menangani proses login ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } else {
        // Mencari pengguna berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM mitra WHERE Email_Mitra = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Memverifikasi password jika email ditemukan
        if ($user) {
            // Cek status akun
            if ($user['Status'] === 'menunggu') {
                $error = "Akun Anda sedang menunggu konfirmasi dari admin.";
            } elseif (password_verify($password, $user['Password_Mitra'])) {
                // Menyimpan data pengguna di session
                $_SESSION['user_id'] = $user['Id_Mitra'];
                $_SESSION['username'] = $user['Nama_Mitra'];
                $_SESSION['role'] = 'mitra';

                // Redirect ke halaman dashboard
                header('Location: ../mitra/dashboard.php');
                exit();
            } else {
                $error = "Email atau password salah.";
            }
        } else {
            $error = "Email tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mitra</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="login_mitra.php" method="post">
            <h1>Selamat Datang Di OTAKA</h1>
            
            <!-- Input Email -->
            <input type="email" id="email" name="email" placeholder="Email" required>

            <!-- Input Password -->
            <input type="password" id="password" name="password" placeholder="Password" required>

            <!-- Error message -->
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            
            <!-- Login Button -->
            <button type="submit" id="btn-auth">Login</button>
            
            <!-- Link ke halaman registrasi -->
            <p>Belum mempunyai akun? <a href="./register_mitra.php">Daftar Sekarang</a></p>
        </form>
    </main>
</body>
</html>
