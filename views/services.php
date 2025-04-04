<!DOCTYPE html>
<html>
<head>
    <title>Hizmetlerim</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="bg-dark text-white p-3">
        <nav class="container">
            <a href="#" class="text-white">Hosting</a>
            <a href="#" class="text-white">Alan Adı</a>
            <a href="index.php?action=logout" class="text-white">Çıkış Yap</a>
            <a href="index.php?action=services" class="text-white">Hizmetlerim</a>
        </nav>
    </header>

    <main class="container mt-4">
        <h1>Hizmetlerim</h1>

        <?php if (empty($services)): ?>
            <p>Henüz bir hizmetiniz bulunmamaktadır.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Hizmet Adı</th>
                        <th>Fiyat</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo $service['name']; ?></td>
                            <td><?php echo $service['price']; ?></td>
                            <td><a href="index.php?action=detail&id=<?php echo $service['id']; ?>">Detaylar</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </main>

    <footer class="bg-light text-center p-3">
        <p>&copy; 2024 Hosting ve Alan Adı</p>
    </footer>

</body>
</html>