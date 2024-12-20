<?php
require '../service/connection.php';
session_start();

// Validasi sesi: pastikan user_id dan role admin tersedia
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login_admin.php'); // Redirect ke login admin jika sesi tidak valid
    exit();
}

// Ambil daftar mitra dengan status "menunggu"
$stmt = $pdo->prepare("SELECT * FROM mitra WHERE status = 'menunggu'");
$stmt->execute();
$mitra_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Mitra</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <h1>Daftar Mitra Menunggu Persetujuan</h1>

    <!-- Tampilkan pesan sukses atau error -->
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php elseif (isset($_GET['error'])): ?>
        <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mitra_list as $mitra): ?>
            <tr>
                <td><?php echo htmlspecialchars($mitra['Id_Mitra']); ?></td>
                <td><?php echo htmlspecialchars($mitra['nama']); ?></td>
                <td><?php echo htmlspecialchars($mitra['email']); ?></td>
                <td><?php echo htmlspecialchars($mitra['status']); ?></td>
                <td>
                    <a href="approve_mitra_action.php?id=<?php echo $mitra['Id_Mitra']; ?>&action=approve">Setujui</a>
                    <a href="approve_mitra_action.php?id=<?php echo $mitra['Id_Mitra']; ?>&action=reject">Tolak</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
