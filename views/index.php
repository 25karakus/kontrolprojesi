<!DOCTYPE html>
<html>
<head>
    <title>Hosting ve Alan Adı</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="bg-dark text-white p-3">
        <nav class="container">
            <a href="#" class="text-white">Hosting</a>
            <a href="#" class="text-white">Alan Adı</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?action=logout" class="text-white">Çıkış Yap</a>
                <a href="index.php?action=services" class="text-white">Hizmetlerim</a>
            <?php else: ?>
                <a href="index.php?action=login" class="text-white">Giriş Yap</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container mt-4">
        <h1>Hoş Geldiniz!</h1>
        <p>Hosting ve alan adı hizmetlerimiz hakkında bilgi almak için lütfen menüyü kullanın.</p>
    </main>

    <footer class="bg-light text-center p-3">
        <p>&copy; 2024 Hosting ve Alan Adı</p>
    </footer>

</body>
</html>