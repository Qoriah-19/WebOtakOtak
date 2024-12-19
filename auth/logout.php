<?php
session_start();
session_destroy();

// Periksa peran pengguna dan alihkan ke halaman login yang sesuai
if (isset($_GET['role'])) {
    $role = $_GET['role'];
    if ($role === 'pengguna') {
        header('Location: ../auth/login_user.php');
    } elseif ($role === 'mitra') {
        header('Location: ../auth/login_mitra.php');
    } elseif ($role === 'admin') {
        header('Location: ../auth/login_admin.php');
    } else {
        header('Location: auth/login.php'); // Halaman login default
    }
} else {
    header('Location: auth/login.php'); // Halaman login default
}
exit();
?>
