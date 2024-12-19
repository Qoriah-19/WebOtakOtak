<?php
require '../service/connection.php';

session_start();
// if(isset($_SESSION['user_id'])){
//     header('Location: ../index.php');
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nama = $_POST['Nama'];
    $confirm_password = $_POST['confirm_password'];
    $Alamat = $_POST['Alamat'];
    $No_Hp = $_POST['No_Hp'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT);

    // Cek apakah name atau email sudah ada
    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Nama = ? OR Email = ?");
    $stmt->execute([$Nama, $Email]);
    $user = $stmt->fetch();

    if ($user) {
        $error = "Nama atau Email sudah digunakan.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO pengguna (Nama, Email, Password, Alamat, No_Hp) VALUES (?,?,?,?,?)");
        if ($stmt->execute([$Nama, $Email, $Password,$Alamat,$No_Hp])) {
            header('Location: ./login_user.php');
        } else {
            $error = "Registration failed. Please try again.";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <main class="main">
        <img src="../assets/images/login_image.png" alt="login">
        <form class="container_form" action="register_user.php" method="post">
            <h1>Daftar Akun Pengguna</h1>
            <input type="text" id="Nama" name="Nama" placeholder="Nama pengguna" required>
            <input type="text" id="Email" name="Email" placeholder="Email" required>
            <input type="password" id="Password" name="Password" placeholder="Password" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="konfirmasi password" required>
            <input type="text" id="Alamat" name="Alamat" placeholder="Alamat " required>
            <input type="number" id="No_Hp" name="No_Hp" placeholder="No Hp" required>
        
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" id="btn-auth">Daftar</button>
            <p>Sudah mempunyai akun ? <a href="./login_user.php">Login Sekarang</a> </p>
        </form>
    </main>
</body>
</html>
