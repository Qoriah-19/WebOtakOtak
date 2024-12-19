<?php
// Mengambil data toko berdasarkan ID yang dikirimkan melalui URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$image = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : 'default.png';
$title = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : 'Nama Toko Tidak Diketahui';

// Daftar informasi yang berbeda untuk setiap toko berdasarkan ID
$toko_info = [
    1 => [
        'name' => 'Otak-Otak Bu Yana',
        'address' => 'Jl. Merdeka No. 123, Tanjungpinang',
        'hours' => 'Setiap hari: 10:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak sotong', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Tulang', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'yana2.png',
        'map_url' => 'https://www.google.com/maps?q=Jl.+Merdeka+No.+123,+Tanjungpinang',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/buyana',
            'facebook' => 'https://www.facebook.com/buyana',
            'whatsapp' => 'https://wa.me/1234567890'  // Nomor WhatsApp untuk Bu Yana
        ]
    ],
    2 => [
        'name' => 'Otak-Otak Cik Endang',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 10:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Sotong', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Tulang', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak  Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'cikendang1.png',
        'map_url' => 'hhttps://maps.app.goo.gl/LvsUZgystskVeYCk6',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Cik Endang
        ]
    ],
    3 => [
        'name' => 'Otak-Otak Ibu Yana',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Sotong', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Tulang', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'ibuyana1.png',
        'map_url' => 'hhttps://maps.app.goo.gl/aDuBzmqAkKeZUGEV7',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Ibu Yana
        ]
    ],
    4 => [
        'name' => 'Otak-Otak Kak Ita',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Sotong', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Tulang', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'kakita.png',
        'map_url' => 'https://www.google.com/maps?q=Jl.+Raya+Bintan+No.+45,+Bintan+Timur',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Kak Ita
        ]
    ],
    5 => [
        'name' => 'Otak-Otak Kak Ju',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-22:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Sotong', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Tulang', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'kakju.png',
        'map_url' => 'https://www.google.com/maps?q=Jl.+Raya+Bintan+No.+45,+Bintan+Timur',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk kakju
        ]
    ],
    6 => [
        'name' => 'Otak-Otak Mak Bona',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Sotong', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Rebus', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'bona.png',
        'map_url' => 'https://maps.app.goo.gl/PUhU5S8YHPkc4XHP7',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Mak Bona
        ]
    ],
    7 => [
        'name' => 'Otak-Otak Mak Ciros',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Bakar', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Rebus', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']

        ],
        'image' => 'makciros.png',
        'map_url' => 'https://www.google.com/maps?q=Jl.+Raya+Bintan+No.+45,+Bintan+Timur',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Mak Ciros
        ]
    ],
    8 => [
        'name' => 'Otak-Otak Mak Long',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Bakar', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Rebus', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Kerupuk Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'maklong.png',
        'map_url' => 'https://maps.app.goo.gl/76JBUU6KtRGcAzmz5',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Mak Long
        ]
    ],
    9 => [
        'name' => 'Otak-Otak Mak Oteh',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Bakar', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Rebus', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'makoteh.png',
        'map_url' => 'https://maps.app.goo.gl/Y2Qur48Kjnif7Stp9',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Cik Endang
        ]
    ],
    10 => [
        'name' => 'Otak-Otak Mak Ucu',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Bakar', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Rebus', 'price' => 'Rp 1.500/pcs'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500/pcs']
        ],
        'image' => 'Otakmakucu.png',
        'map_url' => 'https://maps.app.goo.gl/uPw7NzTJnwa8scNx7',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Cik Endang
        ]
    ],
    11 => [
        'name' => 'Otak-Otak Wati',
        'address' => 'Jl. Raya Bintan No. 45, Bintan Timur',
        'hours' => 'Setiap hari: 09:00-18:00 WIB',
        'menu' => [
            ['item' => 'Otak-Otak Bakar', 'price' => 'Rp 1.500'],
            ['item' => 'Otak-Otak Rebus', 'price' => 'Rp 1.500'],
            ['item' => 'Otak-Otak Ikan', 'price' => 'Rp 1.500']
        ],
        'image' => 'wati.png',
        'map_url' => 'https://maps.app.goo.gl/di2SwCJKcPcbgL2c8',
        'social_media' => [
            'instagram' => 'https://www.instagram.com/cikendang',
            'facebook' => 'https://www.facebook.com/cikendang',
            'whatsapp' => 'https://wa.me/9876543210'  // Nomor WhatsApp untuk Cik Endang
        ]
    ],
];


// Menampilkan informasi toko berdasarkan ID yang diberikan
$toko = $toko_info[$id] ?? $toko_info[1];
?>

<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] == 'guest') {
    // Jika pengguna belum login, arahkan ke halaman login
    echo '<script>
            alert("Anda harus login terlebih dahulu untuk memesan.");
            window.location.href = "auth/login_user.php";
          </script>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Toko Otak-Otak - <?php echo $toko['name']; ?></title>
    <link rel="stylesheet" href="../assets/css/detail.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Pesan Otak-Otak</h1>
        </div>
    </header>

    <main id="detail_page">
        <section class="store-info">
            <h2 class="title"><?php echo $toko['name']; ?></h2>
            <div class="store-image">
                <a href="path-to-image-gallery-or-enlarged-image.php?image=<?php echo urlencode($toko['image']); ?>" target="_blank">
                    <img src="../assets/images/<?php echo $toko['image']; ?>" alt="<?php echo $toko['name']; ?>">
                </a>
                <div class="store-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <span class="rating">&#9733;</span>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <section class="store-details">
            <div class="details">
                <p><strong>Alamat:</strong> <?php echo $toko['address']; ?></p>
                <p><strong>Waktu Operasional:</strong> <?php echo $toko['hours']; ?></p>
            </div>
            <div class="map-box">
                <a href="<?php echo $toko['map_url']; ?>" target="_blank" class="map-link">
                    <div class="map">
                        <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo urlencode($toko['address']); ?>&zoom=14&size=600x300&markers=color:red%7Clabel:%7C<?php echo urlencode($toko['address']); ?>&key=YOUR_GOOGLE_MAPS_API_KEY" alt="Peta Lokasi">
                    </div>
                </a>
            </div>
            <div class="menu">
                <h3>Menu</h3>
                <ul>
                    <?php foreach ($toko['menu'] as $menu_item): ?>
                        <li><?php echo htmlspecialchars($menu_item['item']); ?> - <?php echo htmlspecialchars($menu_item['price']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

         <!-- Tombol Pesan Sekarang -->
         <section class="order-section">
            <button id="orderNow" onclick="handleOrderClick(<?php echo $is_logged_in ? 'true' : 'false'; ?>)">
                Pesan Sekarang
            </button>
        </section>

        <section class="social-media">
            <h3>Sosial Media</h3>
            <!-- Link ke sosial media masing-masing toko -->
            <a href="<?php echo $toko['social_media']['instagram']; ?>" target="_blank">Instagram</a>
            <a href="<?php echo $toko['social_media']['facebook']; ?>" target="_blank">Facebook</a>
            <a href="<?php echo $toko['social_media']['whatsapp']; ?>" target="_blank">WhatsApp</a>
        </section>

        <section class="back-to-home">
            <a href="../index.php"><button class="back-btn">Kembali ke Beranda</button></a>
        </section>
    </main>
</body>
</html>
