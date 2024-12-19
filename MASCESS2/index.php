<?php
require 'service/connection.php';
session_start();

// Cek role pengguna
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

// Tentukan halaman
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Daftar halaman yang valid untuk tiap role
$valid_pages = [
    'home' => ['guest', 'pengguna', 'admin'],
    'news' => ['guest', 'pengguna', 'admin'],
    'info' => ['guest', 'pengguna', 'admin'],
    'about' => ['guest', 'pengguna', 'admin'],
    'produk' => ['pengguna'],
    'riwayat' => ['pengguna'],
    'setting' => ['pengguna'],
    'approve_mitra' => ['admin'],
    'approve_produk' => ['admin'],
];

// Validasi halaman
if (!array_key_exists($page, $valid_pages) || !in_array($role, $valid_pages[$page])) {
    $page = 'home';
}

// Include tampilan halaman
include 'includes/header.php';
include 'includes/navigasi.php';
include "pages/$page.php";
include 'includes/footer.php';
?>
