<!DOCTYPE html>
<html>
<head>
    <title>Destek Talebi Detayı</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<div class="destek-talebi-detay-container hosting-temasi">
    <h2>Destek Talebi Detayı</h2>

    <?php if (isset($talep)): ?>
        <div class="talep-detay hosting-detay-kutusu">
            <h3><?php echo htmlspecialchars($talep['baslik']); ?></h3>
            <p><strong>Oluşturma Tarihi:</strong> <?php echo htmlspecialchars($talep['olusturma_tarihi']); ?></p>
            <p><strong>Açıklama:</strong> <?php echo htmlspecialchars($talep['aciklama']); ?></p>
            <p><strong>Durum:</strong> <span class="durum-etiketi <?php echo strtolower(htmlspecialchars($talep['durum'])); ?>"><?php echo htmlspecialchars($talep['durum']); ?></span></p>
        </div>

        <div class="yanitlar-bolumu hosting-bolum">
            <h3>Yanıtlar</h3>
            <?php if (!empty($yanitlar)): ?>
                <ul class="yanit-listesi hosting-listesi">
                    <?php foreach ($yanitlar as $yanit): ?>
                        <li class="yanit-item hosting-list-item">
                            <p><strong><?php echo htmlspecialchars($yanit['kullanici_ad']); ?>:</strong> <?php echo htmlspecialchars($yanit['yanit']); ?></p>
                            <p class="yanit-tarih hosting-tarih"><strong>Tarih:</strong> <?php echo htmlspecialchars($yanit['tarih']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Henüz yanıt bulunmamaktadır.</p>
            <?php endif; ?>

            <form action="index.php?action=yanit-ekle&id=<?php echo intval($talep['id']); ?>" method="post" class="yanit-formu hosting-form">
                <textarea name="yanit" placeholder="Yanıtınızı girin" rows="4" required></textarea><br>
                <button type="submit" class="hosting-buton">Yanıt Gönder</button>
            </form>
        </div>

        <div class="yorumlar-bolumu hosting-bolum">
            <h3>Yorumlar</h3>
            <?php if (isset($yorumlar) && !empty($yorumlar)): ?>
                <ul class="yorum-listesi hosting-listesi">
                    <?php foreach ($yorumlar as $yorum): ?>
                        <li class="yorum-item hosting-list-item">
                            <p><strong><?php echo htmlspecialchars($yorum['kullanici_ad']); ?>:</strong> <?php echo htmlspecialchars($yorum['yorum']); ?></p>
                            <p class="yorum-tarih hosting-tarih"><strong>Tarih:</strong> <?php echo htmlspecialchars($yorum['tarih']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Henüz yorum bulunmamaktadır.</p>
            <?php endif; ?>

            <form action="index.php?action=yorum-ekle&id=<?php echo intval($talep['id']); ?>" method="post" class="yorum-formu hosting-form">
                <textarea name="yorum" placeholder="Yorumunuzu girin" rows="4" required></textarea><br>
                <button type="submit" class="hosting-buton">Yorum Gönder</button>
            </form>
        </div>

    <?php else: ?>
        <p>Destek talebi bulunamadı.</p>
    <?php endif; ?>
</div>

</body>
</html>