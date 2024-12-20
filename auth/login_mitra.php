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
        $stmt = $pdo->prepare("SELECT * FROM mitra WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Memverifikasi password jika email ditemukan
        if ($user && password_verify($password, $user['password'])) {
            // Menyimpan data pengguna di session
            $_SESSION['user_id'] = $user['Id_Mitra'];
            $_SESSION['username'] = $user['nama'];
            $_SESSION['role'] = 'mitra'; // Menyimpan role pengguna di session

            // Redirect ke halaman dashboard
            header('Location: ../mitra/dashboard.php');
            exit();
        } else {
            $error = "Email atau password salah.";
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
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="login_mitra.php" method="post">
            <h1>Selamat Datang Di Siberna</h1>
            
            <!-- Input Email -->
            <input type="email" id="email" name="email" placeholder="Email" required>

            <!-- Input Password -->
            <input type="password" id="password" name="password" placeholder="Password" required>

            <!-- Error message -->
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <!-- Login Button -->
            <button type="submit" id="btn-auth">Login</button>
            
            <!-- Link ke halaman registrasi -->
            <p>Belum mempunyai akun? <a href="./register_mitra.php">Daftar Sekarang</a></p>
        </form>
    </main>
</body>
</html>
