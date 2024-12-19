<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Warung Otak-Otak</title>
    <link rel="stylesheet" href="assets/css/info.css">
</head>
<body>
    <header>
        <h1>Informasi Warung Otak-Otak</h1>
    </header>

    <main id="info">
        <?php 
        // Menetapkan gambar secara langsung dan nama toko
        $images = [
            'yana2.png' => 'Otak-Otak Bu Yana ',
            'cikendang1.png' => 'Otak-Otak Cik Endang',
            'ibuyana1.png' => 'Otak-Otak Ibu Yana',
            'kakita.png' => 'Otak-Otak Kak Ita',
            'kakju.png' => 'Otak-Otak  Kak Ju',
            'bona.png' => 'Otak-Otak Bona',
            'makciros.png' => 'Otak-Otak Mak Ciros',
            'maklong.png' => 'Otak-Otak Mak Long',
            'makoteh.png' => 'Otak-Otak Mak Oteh',
            'otakmakucu.png' => 'Otak-Otak Mak Ucu',
            'paktomi.png' => 'Otak-Otak Pak Tomi',
            'pakmok.png' => 'Otak-Otak Pak Mok',
            'pakoteh.png' => 'Otak-Otak Pak Oteh',
            'wati2.png' => 'Otak-Otak Wati '
        ];
        // Mock IDs untuk gambar
        $ids = range(1, count($images)); // Asumsi ID dimulai dari 1
        ?>
        <ul class="data-list">
            <?php 
            $index = 0;
            foreach ($images as $image => $title): 
            ?>
            <li class="clickable-item card">
                <a href="pages/detail.php?id=<?php echo $ids[$index]; ?>&image=<?php echo urlencode($image); ?>&title=<?php echo urlencode($title); ?>">
                    <div>
                        <img src="assets/images/<?php echo htmlspecialchars($image); ?>" alt="img">
                        <div class="title">
                            <div>
                                <p><?php echo htmlspecialchars($title); ?></p>
                            </div>
                            <div class="block-rating">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <?php if ($i < 4): ?>
                                        <span class="rating">&#9733;</span> <!-- Filled star -->
                                    <?php else: ?>
                                        <span class="rating">&#9734;</span> <!-- Empty star -->
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <?php 
            $index++;
            endforeach; 
            ?>
        </ul>
    </main>
</body>
</html>
