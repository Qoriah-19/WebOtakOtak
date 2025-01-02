<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_admin.php');  // Redirect ke halaman login jika bukan admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="../assets/js/script.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Dashboard Admin UMKM Kita</h1>
    </header>

    <!-- Sidebar / Menu -->
    <nav>
        <ul class="nav-menu">
            
            <li>
                <ul class="dropdown">
                    <li><a href="approve_mitra.php">Approve Mitra</a></li>
                    <li><a href="approve_produk_mitra.php">Approve Produk</a></li>
                    <li><a href="laporan.php">Laporan Mitra dan Produk</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Footer -->
    <footer>
        &copy; 2024 UMKM Kita - All rights reserved.
    </footer>
</body>
</html>
