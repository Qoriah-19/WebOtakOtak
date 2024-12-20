<?php
require '../service/connection.php';
session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_admin.php'); // Redirect ke halaman login admin jika bukan admin
    exit();
}

// Validasi input dari parameter URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Periksa apakah parameter `id` dan `action` valid
if (!$id || !$action) {
    header('Location: approve_mitra.php?error=Parameter tidak valid.');
    exit();
}

// Proses aksi berdasarkan `action`
if ($action === 'approve' || $action === 'reject') {
    // Tentukan status baru berdasarkan aksi
    $status = $action === 'approve' ? 'approved' : 'rejected';

    // Update status mitra di database
    $stmt = $pdo->prepare("UPDATE mitra SET status = ? WHERE Id_Mitra = ?");
    if ($stmt->execute([$status, $id])) {
        $message = $action === 'approve' ? 'Mitra berhasil disetujui.' : 'Mitra berhasil ditolak.';
        header("Location: approve_mitra.php?message=$message"); // Redirect dengan pesan sukses
        exit();
    } else {
        // Jika gagal memperbarui status
        header('Location: approve_mitra.php?error=Gagal memproses aksi.');
        exit();
    }
} else {
    // Jika aksi tidak valid
    header('Location: approve_mitra.php?error=Aksi tidak valid.');
    exit();
}
?>
