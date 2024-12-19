<?php
require '../service/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login_user.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna
$stmt = $pdo->prepare("SELECT * FROM pengguna WHERE Id_Pengguna = ?");
$stmt->execute([$user_id]);
$pengguna = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $address = $_POST['alamat'];
    $phone = $_POST['no_hp'];

    // Update data pengguna
    $stmt = $pdo->prepare("UPDATE pengguna SET nama = ?, email = ?, alamat = ?, no_hp = ? WHERE Id_Pengguna = ?");
    if ($stmt->execute([$name, $email, $address, $phone, $user_id])) {
        header('Location: dashboard.php?message=Profil berhasil diperbarui.');
        exit();
    } else {
        $error = "Gagal memperbarui profil. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            color: #555;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 14px;
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="edit_profile.php" method="post">
        <h1>Edit Profil</h1>
        
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($pengguna['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pengguna['email'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($pengguna['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>

        <label for="no_hp">No. HP</label>
        <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pengguna['no_hp'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <?php if (isset($error)): ?>
            <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <button type="submit">Perbarui Profil</button>
    </form>
</body>
</html>
