<!DOCTYPE html>
<html>
<head>
    <title>Hizmetler</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Hizmetler</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Hizmet Adı</th>
                <th>Açıklama</th>
                <th>Fiyat</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($hizmetler) && is_array($hizmetler) && !empty($hizmetler)): ?>
                <?php foreach ($hizmetler as $hizmet): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($hizmet['ad']); ?></td>
                        <td><?php echo htmlspecialchars($hizmet['aciklama']); ?></td>
                        <td><?php echo htmlspecialchars($hizmet['fiyat']); ?></td>
                        <td>
                            <a href="index.php?action=hizmet-detay&id=<?php echo htmlspecialchars($hizmet['id']); ?>">Detay</a>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="index.php?action=hizmet-satinal&id=<?php echo htmlspecialchars($hizmet['id']); ?>">Satın Al</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Hizmet bulunamadı.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>