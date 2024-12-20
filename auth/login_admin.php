<?php
require '../service/connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email ada di database
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        // Set data sesi untuk user yang berhasil login
        $_SESSION['user_id'] = $user['Id_Admin'];
        $_SESSION['username'] = $user['nama']; // Pastikan kolom 'nama' ada di tabel admin
        $_SESSION['role'] = 'admin'; // Tambahkan role ke sesi

        // Redirect ke dashboard
        header('Location: /otakuu/admin/dashboard.php'); 
        exit();

    } else {
        $error = "Email atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="/otakuu/auth/login_admin.php" method="post"> <!-- Gunakan path absolut -->
            <h1>Selamat Datang Di Otaka</h1>
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" id="btn-auth">Login</button>
        </form>
    </main>
</body>
</html>
