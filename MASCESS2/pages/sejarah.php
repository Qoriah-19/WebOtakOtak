<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Sungai Enam</title>
    <link rel="stylesheet" href="../assets/css/sejarah.css">
</head>
<body>
    <main id="news">
        <div class="title-box">
            <p class="title">SEJARAH SUNGAI ENAM</p>
        </div>

        <div class="data-list">
            
            <div class="informasi">
                <p>Kelurahan Sungai Enam memiliki sejarah panjang yang kaya akan budaya dan peristiwa penting. Nama "Sungai Enam" sendiri berasal dari keberadaan enam sungai yang mengelilingi wilayah ini. Sejarah mencatat bahwa daerah ini pernah menjadi pusat perdagangan penting di zaman dahulu, berkat letaknya yang strategis di kawasan Kepulauan Riau.</p>
                
                <p>Selama abad ke-17, Sungai Enam dikenal sebagai pelabuhan kecil yang menjadi tempat transit bagi para pedagang dari berbagai negara. Selama masa penjajahan Belanda, daerah ini sempat dijadikan jalur perdagangan utama antara Pulau Bintan dan Singapura.</p>
                
                <p>Selain itu, Sungai Enam juga memiliki sejarah yang erat dengan masyarakat nelayan yang telah mendiami daerah ini sejak zaman dahulu. Perkampungan nelayan di Sungai Enam dikenal dengan tradisi dan kebudayaan yang masih dilestarikan hingga saat ini. Kebanyakan warga Sungai Enam menggantungkan hidupnya pada hasil laut dan kegiatan pertanian kecil.</p>
                
                <p>Seiring berjalannya waktu, Sungai Enam berkembang menjadi sebuah kawasan yang lebih modern. Walaupun begitu, nilai-nilai tradisional dan budaya masyarakat setempat tetap terjaga dengan baik, memberikan warna khas bagi kehidupan di daerah ini. Banyak wisatawan yang tertarik mengunjungi Sungai Enam untuk mempelajari sejarahnya yang menarik dan juga menikmati keindahan alam yang ada di sekitarnya.</p>
                
                <p>Kelurahan Sungai Enam kini menjadi salah satu tujuan wisata budaya dan sejarah di Kabupaten Bintan, dan peranannya dalam perekonomian lokal semakin penting dengan adanya berbagai fasilitas publik dan tempat wisata yang terus berkembang.</p>
                
                <button id="back-button" onclick="window.location.href='../index.php';">
                    Kembali ke Beranda
                </button>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('li[data-id]').forEach(item => {
            item.addEventListener('click', () => {
                console.log("disini");
                const id = item.getAttribute('data-id');
                window.location.href = `index.php?page=detailnews&id=${id}`;
            });
        });
    </script>
</body>
</html>
