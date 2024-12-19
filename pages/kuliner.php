<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuliner Sungai Enam</title>
    <link rel="stylesheet" href="../assets/css/kuliner.css">
</head>
<body>
    <main id="news">
        <div class="title-box">
            <p class="title">KULINER DI SUNGAI ENAM</p>
        </div>
        
        <div class="data-list">
            <div class="informasi">
                <p>Sungai Enam dikenal dengan keberagaman kuliner yang menggugah selera, memadukan cita rasa lokal dan pengaruh budaya luar. Daerah ini memiliki banyak makanan khas yang harus Anda coba. Beberapa di antaranya telah dikenal luas di Kepulauan Riau, namun tetap mempertahankan rasa otentiknya yang hanya dapat ditemukan di Sungai Enam.</p>
                
                <div class="kuliner-item">
                    <h2 class="subtitle">1. Otak-Otak Bintan</h2>
                    <img src="../images/otak.png" alt="Otak-Otak Bintan">
                    <p>Otak-otak Bintan merupakan hidangan khas yang terbuat dari ikan yang dibalut dengan daun pisang dan dibakar. Rasanya yang gurih dan tekstur ikan yang kenyal membuat otak-otak menjadi camilan favorit bagi banyak orang. Di Sungai Enam, otak-otak ini dijual di banyak kios dan sangat populer di kalangan wisatawan.</p>
                </div>
                
                <div class="kuliner-item">
                    <h2 class="subtitle">2. Lontong Sayur Sungai Enam</h2>
                    <img src="../images/lontong-sayur.jpg" alt="Lontong Sayur">
                    <p>Lontong Sayur adalah salah satu hidangan sarapan yang populer di Sungai Enam. Disajikan dengan lontong, sayur lodeh, dan sambal pedas, menjadikannya pilihan yang sempurna untuk memulai hari. Hidangan ini tidak hanya mengenyangkan tetapi juga memiliki rasa yang kaya dengan bumbu rempah yang khas.</p>
                </div>
                
                <div class="kuliner-item">
                    <h2 class="subtitle">3. Mie Tiauw</h2>
                    <img src="../images/mie-tiauw.jpg" alt="Mie Tiauw">
                    <p>Mie Tiauw adalah hidangan mie khas yang dimasak dengan bumbu saus kecap dan pilihan daging seperti ayam atau sapi. Rasanya yang manis, asin, dan sedikit pedas membuat mie tiauw di Sungai Enam menjadi salah satu favorit warga lokal dan wisatawan.</p>
                </div>
                
                <div class="kuliner-item">
                    <h2 class="subtitle">4. Ikan Bakar</h2>
                    <img src="../images/ikan-bakar.jpg" alt="Ikan Bakar">
                    <p>Ikan bakar adalah hidangan wajib saat berkunjung ke Sungai Enam. Ikan segar yang dibakar dengan bumbu khas membuat rasa ikan semakin nikmat. Banyak rumah makan di sekitar Sungai Enam yang menyajikan ikan bakar dengan berbagai pilihan sambal yang menggugah selera.</p>
                </div>
                
                <div class="kuliner-item">
                    <h2 class="subtitle">5. Kue Cubir</h2>
                    <img src="../images/kue-cubir.jpg" alt="Kue Cubir">
                    <p>Kue Cubir adalah jajanan tradisional yang terbuat dari tepung beras dengan isian kelapa parut yang manis. Kue ini sering dijadikan oleh-oleh bagi wisatawan yang datang ke Sungai Enam.</p>
                </div>
                
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
