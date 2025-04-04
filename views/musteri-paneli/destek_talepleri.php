<h2>Destek Taleplerim</h2>

<?php if (!empty($destek_talepleri)): ?>
    <table>
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Oluşturma Tarihi</th>
                <th>Durum</th>
                <th>Detaylar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($destek_talepleri as $talep): ?>
                <tr>
                    <td><?php echo $talep['baslik']; ?></td>
                    <td><?php echo $talep['olusturma_tarihi']; ?></td>
                    <td><?php echo $talep['durum']; ?></td>
                    <td><a href="index.php?action=destek-talebi-detay&id=<?php echo $talep['id']; ?>">Detay</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Henüz destek talebiniz bulunmamaktadır.</p>
<?php endif; ?>

<a href="index.php?action=destek-talebi-olustur">Yeni Destek Talebi Oluştur</a>