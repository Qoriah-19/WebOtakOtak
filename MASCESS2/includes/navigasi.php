<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar dengan Dropdown</title>
    <link rel="stylesheet" href="assets/css/navigasi.css">
</head>
<body>
    <!-- Navbar -->
    <div class="nav">
        <!-- Logo -->
        <div class="nav-logo">
            <img src="assets/images/logo.png" alt="logo">
            <h2>OTAKKA</h2>
        </div>
        <!-- Menu -->
        <ul class="nav-menu">
            <li>
                <a href="index.php">Beranda</a>
            </li>

            <li>
                <a href="index.php?page=news">Profil Sungai Enam</a>
                <ul class="dropdown">
                    
                    <li> <a href="pages/sejarah.php" class="dropdown-item">Sejarah</a></li>
                  
                </ul>
            </li>


            <li>
                <a href="#">Login</a>
                <ul>
                    <li><a href="auth/login_admin.php">Admin</a></li>
                    <li><a href="auth/login_user.php">User</a></li>
                    <li><a href="auth/login_mitra.php">Mitra</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Regis</a>
                <ul>
                    <li><a href="auth/register_user.php">Daftar Pengguna</a></li>
                    <li><a href="auth/register_mitra.php">Daftar Mitra</a></li>
                </ul>
            </li>
        </ul>
    </div>
</body>
</html>
