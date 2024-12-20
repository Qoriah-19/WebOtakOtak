<?php
require '../service/connection.php';

session_start();
// if(isset($_SESSION['user_id'])){
//     header('Location: ../index.php');
// }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['Id_Pengguna'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../pengguna/dashboard.php?role=pengguna');
        exit;
    } else {
        $error = "Invalid username or password.";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="login_user.php" method="post">
            <h1>Selamat Datang Di Siberna</h1>
            <input type="text" id="email" name="email" placeholder="email" required>
            <input type="password" id="password" name="password" placeholder="password" required>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" id="btn-auth">Login</button>
            <p>Belum mempunyai akun ? <a href="./register_user.php">Daftar Sekarang</a> </p>
        </form>
    </main>
</body>
</html>
