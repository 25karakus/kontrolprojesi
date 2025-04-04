<!DOCTYPE html>
<html>
<head>
    <title>Faturalar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Faturalar</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Fatura No</th>
                <th>Tarih</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Detay</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($faturalar) && is_array($faturalar) && !empty($faturalar)): ?>
                <?php foreach ($faturalar as $fatura): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fatura['fatura_no']); ?></td>
                        <td><?php echo htmlspecialchars($fatura['tarih']); ?></td>
                        <td><?php echo htmlspecialchars($fatura['tutar']); ?></td>
                        <td><?php echo htmlspecialchars($fatura['durum']); ?></td>
                        <td><a href="index.php?action=fatura-detay&id=<?php echo htmlspecialchars($fatura['id']); ?>">Detay</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Fatura bulunamadı.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>