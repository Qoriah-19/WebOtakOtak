<?php
require '../service/connection.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_admin.php'); // Arahkan ke login admin jika bukan admin
    exit();
}

// Validasi input dari URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Mengambil id produk (validasi integer)
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING); // Mengambil aksi (approve/reject)

// Cek apakah parameter valid
if (!$id || !$action) {
    header('Location: approve_produk_mitra.php?error=Parameter tidak valid.');
    exit();
}

// Proses aksi approve/reject
try {
    // Proses approve
    if ($action === 'approve') {
        // Periksa apakah produk dengan ID ini ada
        $stmt_check = $pdo->prepare("SELECT * FROM produk WHERE Id_Produk = ?");
        $stmt_check->execute([$id]);
        $product = $stmt_check->fetch();

        if ($product) {
            // Update status produk menjadi "approved"
            $stmt = $pdo->prepare("UPDATE produk SET status = 'terkonfirmasi' WHERE Id_Produk = ?");
            if ($stmt->execute([$id])) {
                header('Location: approve_produk_mitra.php?message=Produk berhasil disetujui.');
                exit();
            } else {
                header('Location: approve_produk_mitra.php?error=Gagal mengubah status produk.');
                exit();
            }
        } else {
            header('Location: approve_produk_mitra.php?error=Produk tidak ditemukan.');
            exit();
        }
    }

    // Proses reject
    elseif ($action === 'reject') {
        // Periksa apakah produk dengan ID ini ada
        $stmt_check = $pdo->prepare("SELECT * FROM produk WHERE Id_Produk = ?");
        $stmt_check->execute([$id]);
        $product = $stmt_check->fetch();

        if ($product) {
            // Hapus produk dari database
            $stmt = $pdo->prepare("DELETE FROM produk WHERE Id_Produk = ?");
            if ($stmt->execute([$id])) {
                header('Location: approve_produk_mitra.php?message=Produk berhasil ditolak.');
                exit();
            } else {
                header('Location: approve_produk_mitra.php?error=Gagal menghapus produk.');
                exit();
            }
        } else {
            header('Location: approve_produk_mitra.php?error=Produk tidak ditemukan.');
            exit();
        }
    }

    // Jika aksi tidak valid
    else {
        header('Location: approve_produk_mitra.php?error=Aksi tidak valid.');
        exit();
    }
} catch (Exception $e) {
    // Tangani error
    header('Location: approve_produk_mitra.php?error=Terjadi kesalahan. ' . $e->getMessage());
    exit();
}
?>
