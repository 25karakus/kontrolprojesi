<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

    <div class="container-fluid register-form">
        <h2>Kayıt Ol</h2>
        <form method="post" action="index.php?action=kayit">
            <div class="form-group">
                <label for="ad">Ad</label>
                <input type="text" name="ad" id="ad" required>
            </div>
            <div class="form-group">
                <label for="soyad">Soyad</label>
                <input type="text" name="soyad" id="soyad" required>
            </div>
            <div class="form-group">
                <label for="telefon">Telefon Numarası</label>
                <input type="tel" name="telefon" id="telefon" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="sifre_tekrar">Şifre Tekrarı</label>
                <input type="password" name="sifre_tekrar" id="sifre_tekrar" required>
            </div>
            <button type="submit">Kayıt Ol</button>

            <?php
                if (isset($hata_mesaji)) {
                    echo "<p style='color: red;'>$hata_mesaji</p>";
                }

                if (isset($basari_mesaji)) {
                    echo "<p style='color: green;'>$basari_mesaji</p>";
                }
            ?>
        </form>
    </div>

</body>
</html>