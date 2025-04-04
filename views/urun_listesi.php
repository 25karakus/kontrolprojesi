<!DOCTYPE html>
<html>
<head>
    <title>Ürün Listesi</title>
</head>
<body>
    <h2>Ürün Listesi</h2>
    <ul>
        <?php foreach ($urunler as $urun): ?>
            <li>
                <?php echo $urun['ad']; ?> - <?php echo $urun['fiyat']; ?> TL
                <form action="index.php?action=sepet-ekle" method="post">
                    <input type="hidden" name="urun_id" value="<?php echo $urun['id']; ?>">
                    <input type="hidden" name="adet" value="1">
                    <button type="submit">Sepete Ekle</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>