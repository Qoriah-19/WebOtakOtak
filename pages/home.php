<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTAKKA</title>
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>
    <!-- Layer One -->
        <div id="main">
            <div id="layer-one">
            <div class="title">
                <h1>OTAKKA</h1>
                <p>OTAKKA adalah platform yang menyediakan informasi dan sistem e-commerce otak-otak di Sungai Enam Tanjung Pinang. </p>  
            </div>

        </div>

        <!-- Layer Two -->
        <div id="layer-two">
            <h1>Rekomendasi Warung Otak-Otak di Sungai Enam </h1>
            <!-- Bagian 8 Card Gambar -->
            <div class="card-container">
                <!-- Card 1-4 -->
                <div class="card-row">
                    <?php 
                    $images = [
                        "assets/images/bona.png", 
                        "assets/images/cikendang1.png", 
                        "assets/images/ibuyana1.png", 
                        "assets/images/kakita.png"
                    ];

                    $storeNames = [
                        "Otak-Otak Mak Bona", 
                        "Otak-Otak Cik Endang ", 
                        "Otak-Otak Ibu Yana", 
                        "Otak-Otak Kak Ita"
                    ];

                    $categories = [
                        "Makanan Dan Minuman", 
                        "Makanan Dan Minuman", 
                        "Makanan Dan Minuman", 
                        "Makanan Dan Minuman"
                    ];

                    for ($i = 0; $i < 4; $i++): ?>
                        <div class="card">
                            <img src="<?php echo $images[$i]; ?>" alt="Gambar UMKM <?php echo $i+1; ?>">
                            <div class="card-title">
                                <h2><?php echo $storeNames[$i]; ?></h2>
                                <p>Kategori: <?php echo $categories[$i]; ?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
    
                <!-- Card 5-8 (gambar dan nama toko berbeda) -->
                <div class="card-row">
                    <?php 
                    $images2 = [
                        "assets/images/kakju.png", 
                        "assets/images/makciros.png", 
                        "assets/images/maklong.png", 
                        "assets/images/makoteh.png"
                    ];

                    $storeNames2 = [
                        "Otak-Otak Kak Ju", 
                        "Otak-Otak Mak Ciros", 
                        "Otak-Otak Mak Long", 
                        "Otak-Otak Mak Oteh"
                    ];

                    $categories2 = [
                        "Makanan Dan Minuman", 
                        "Makanan Dan Minuman", 
                        "Makanan Dan Minuman", 
                        "Makanan Dan Minuman"
                    ];

                    for ($i = 0; $i < 4; $i++): ?>
                        <div class="card">
                            <img src="<?php echo $images2[$i]; ?>" alt="Gambar UMKM <?php echo $i+5; ?>">
                            <div class="card-title">
                                <h2><?php echo $storeNames2[$i]; ?></h2>
                                <p>Kategori: <?php echo $categories2[$i]; ?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
