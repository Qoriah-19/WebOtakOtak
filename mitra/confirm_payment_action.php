<?php
require '../service/connection.php';
session_start();

// Cek apakah pengguna sudah login sebagai mitra
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_mitra.php');
    exit();
}

// Pastikan parameter id dan action ada
if (isset($_GET['id']) && isset($_GET['action'])) {
    $transaction_id = $_GET['id'];
    $action = $_GET['action'];

    // Tentukan status baru berdasarkan aksi yang dipilih
    if ($action === 'confirm') {
        $new_status = 'terkonfirmasi'; // Status yang akan diterapkan jika pembayaran dikonfirmasi
    } elseif ($action === 'reject') {
        $new_status = 'ditolak'; // Status jika pembayaran ditolak
    } else {
        // Aksi tidak dikenali, redirect atau beri pesan error
        header('Location: confirm_payment.php?error=Aksi tidak valid.');
        exit();
    }

    // Update status transaksi di database
    $stmt = $pdo->prepare("UPDATE transaksi SET Status_Pembayaran = ? WHERE Id_Transaksi = ?");
    if ($stmt->execute([$new_status, $transaction_id])) {
        // Redirect ke halaman konfirmasi pembayaran setelah status diperbarui
        header('Location: confirm_payment.php?message=Status pembayaran berhasil diperbarui.');
        exit();
    } else {
        // Jika gagal memperbarui status
        header('Location: confirm_payment.php?error=Gagal memperbarui status pembayaran.');
        exit();
    }
} else {
    // Jika parameter id atau action tidak ada, redirect atau beri pesan error
    header('Location: confirm_payment.php?error=Parameter tidak valid.');
    exit();
}
