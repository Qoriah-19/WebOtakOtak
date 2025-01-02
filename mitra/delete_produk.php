<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Cek apakah ID produk sudah ada di URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Pastikan produk milik mitra yang sedang login
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE Id_Produk = ? AND Id_Mitra = ?");
    $stmt->execute([$product_id, $user_id]);
    $product = $stmt->fetch();

    if ($product) {
        // Hapus produk dari database
        $deleteStmt = $pdo->prepare("DELETE FROM produk WHERE Id_Produk = ?");
        if ($deleteStmt->execute([$product_id])) {
            // Redirect setelah produk dihapus
            header('Location: manage_produk.php?message=Produk berhasil dihapus.');
            exit();
        } else {
            echo "Terjadi kesalahan saat menghapus produk.";
        }
    } else {
        echo "Produk tidak ditemukan atau Anda tidak memiliki izin untuk menghapus produk ini.";
    }
} else {
    echo "ID produk tidak disediakan.";
}
?>
