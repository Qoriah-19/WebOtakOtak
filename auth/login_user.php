<?php
require '../service/connection.php';

session_start();

// Redirect jika pengguna sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: ../pengguna/dashboard.php?role=pengguna');
    exit();
}

$error = ''; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi.";
    } else {
        // Ambil data pengguna berdasarkan email
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Email_Pengguna = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verifikasi password
        if ($user && password_verify($password, $user['Password_Pengguna'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['Id_Pengguna'];
            $_SESSION['username'] = $user['Nama_Pengguna'];
            $_SESSION['role'] = 'user'; // Menyimpan role pengguna di session
            header('Location: ../pengguna/dashboard.php?role=pengguna');
            exit;
        } else {
            $error = "Email atau password tidak valid.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="login_user.php" method="post">
            <h1>Selamat Datang Di OTAKA</h1>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <button type="submit" id="btn-auth">Login</button>
            <p>Belum mempunyai akun? <a href="./register_user.php">Daftar Sekarang</a></p>
        </form>
    </main>
</body>
</html>
