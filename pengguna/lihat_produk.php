<?php
require '../service/connection.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_user.php');
    exit();
}

// Cek apakah ID produk ada di URL
if (isset($_GET['id'])) {
    $id_produk = (int)$_GET['id'];

    // Ambil data produk
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE Id_Produk = ?");
    $stmt->execute([$id_produk]);
    $produk = $stmt->fetch();

    if (!$produk) {
        header('Location: lihat_produk.php?error=Produk tidak ditemukan.');
        exit();
    }
} else {
    header('Location: lihat_produk.php?error=ID produk tidak ditemukan.');
    exit();
}

$error = ''; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $jumlah = (int)$_POST['jumlah'];
    $total_harga = $produk['Harga'] * $jumlah;
    $status = 'menunggu';

    // Validasi jumlah
    if ($jumlah <= 0) {
        $error = "Jumlah harus lebih dari 0.";
    } else {
        // Cek apakah user_id valid
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Id_Pengguna = ?");
        $stmt->execute([$user_id]);
        if (!$stmt->fetch()) {
            $error = "User ID tidak valid.";
        } else {
            // Upload bukti pembayaran
            if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] == UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['bukti_pembayaran']['tmp_name'];
                $file_name = time() . '_' . basename($_FILES['bukti_pembayaran']['name']);
                $upload_dir = '../uploads/';
                $upload_path = $upload_dir . $file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Masukkan data ke tabel transaksi
                    $stmt = $pdo->prepare("INSERT INTO transaksi (Id_Pengguna, Id_Produk, Jumlah, Total_Harga, Status_Pembayaran, Bukti_Pembayaran) VALUES (?, ?, ?, ?, ?, ?)");
                    if ($stmt->execute([$user_id, $id_produk, $jumlah, $total_harga, $status, $file_name])) {
                        // Simpan konfirmasi pesanan ke tabel konfirmasi_pesanan
                        $stmt = $pdo->prepare("INSERT INTO konfirmasi_pesanan (Id_Produk, Id_Pengguna, Jumlah, Total_Harga) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$id_produk, $user_id, $jumlah, $total_harga]);

                        // Redirect ke dashboard dengan pesan sukses
                        header('Location: dashboard.php?message=Pemesanan berhasil! Silakan tunggu konfirmasi.');
                        exit();
                    } else {
                        $error = "Gagal menyimpan transaksi. Silakan coba lagi.";
                    }
                } else {
                    $error = "Gagal mengunggah bukti pembayaran.";
                }
            } else {
                $error = "Harap unggah bukti pembayaran.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Produk</title>
    <link rel="stylesheet" href="../assets/css/pemesanan.css">
</head>
<body>
    <h1>Pemesanan Produk: <?php echo htmlspecialchars($produk['Nama_Produk']); ?></h1>
    <p>Harga per unit: Rp <?php echo number_format($produk['Harga'], 0, ',', '.'); ?></p>
    
    <form action="pesan_produk.php?id=<?php echo $produk['Id_Produk']; ?>" method="post" enctype="multipart/form-data">
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" min="1" required>
        
        <!-- Total Harga (dihitung otomatis) -->
        <p>Total Harga: Rp <span id="total_harga">0</span></p>

        <label for="bukti_pembayaran">Bukti Pembayaran:</label>
        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" required>
        
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        
        <button type="submit">Pesan</button>
    </form>

    <script>
        // Script untuk menghitung total harga berdasarkan jumlah yang dimasukkan
        const hargaPerUnit = <?php echo $produk['Harga']; ?>;
        
        // Event listener untuk input jumlah
        const jumlahInput = document.getElementById('jumlah');
        const totalHargaElem = document.getElementById('total_harga');
        
        jumlahInput.addEventListener('input', function() {
            const jumlah = parseInt(jumlahInput.value) || 0;
            const totalHarga = hargaPerUnit * jumlah;
            totalHargaElem.textContent = totalHarga.toLocaleString('id-ID');
        });
    </script>
</body>
</html>
