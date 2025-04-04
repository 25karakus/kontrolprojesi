<!DOCTYPE html>
<html>
<head>
    <title>HostingStor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

    <header class="bg-secondary text-white p-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="index.php?action=anasayfa" class="text-white">
                        <h1 class="m-0"><i class="fas fa-server"></i> HOSTINGSTOR</h1>
                    </a>
                </div>
                <div class="col-md-8 text-right">
                    <nav>
                        <a href="index.php?action=anasayfa" class="text-white mx-2"><i class="fas fa-home"></i> Anasayfa</a>
                        <a href="#" class="text-white mx-2"><i class="fas fa-globe"></i> Domain</a>
                        <a href="#" class="text-white mx-2"><i class="fas fa-server"></i> Web Hosting</a>
                        <a href="#" class="text-white mx-2"><i class="fas fa-database"></i> Sunucu</a>
                        <a href="#" class="text-white mx-2"><i class="fas fa-building"></i> Kurumsal</a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="index.php?action=musteri-paneli" class="text-white mx-2"><i class="fas fa-user"></i> Müşteri Paneli</a>
                            <a href="index.php?action=sepet" class="text-white mx-2"><i class="fas fa-shopping-cart"></i> Sepet</a>
                            <a href="index.php?action=cikis" class="text-white mx-2"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
                        <?php else: ?>
                            <a href="index.php?action=giris" class="text-white mx-2"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a>
                            <a href="index.php?action=kayit" class="text-white mx-2"><i class="fas fa-user-plus"></i> Kayıt Ol</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main class="container-fluid mt-4">
        </main>

</body>
</html>