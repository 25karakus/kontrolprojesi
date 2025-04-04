<!DOCTYPE html>
<html>
<head>
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

    <main>
        <div class="container mt-5 login-form">
            <h2>Giriş Yap</h2>
            <form method="post">
                <div class="form-group">
                    <label for="email">E-posta:</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Şifre:</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Giriş Yap</button>
            </form>
            <div class="mt-3">
                <a href="views/musteri-paneli/sifremi_unuttum.php">Şifremi Unuttum</a>
            </div>
        </div>
    </main>

</body>
</html>