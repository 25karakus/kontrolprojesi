<!DOCTYPE html>
<html>
<head>
    <title>Destek Talebi Oluştur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<div class="container mt-5">
    <h2>Destek Talebi Oluştur</h2>
    <form method="post" action="index.php?action=destek-talebi-olustur">
        <div class="form-group">
            <label for="baslik">Başlık</label>
            <input type="text" name="baslik" id="baslik" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="hosting">Hosting</option>
                <option value="alan-adi">Alan Adı</option>
                <option value="email">E-posta</option>
                <option value="ssl">SSL Sertifikası</option>
                <option value="diger">Diğer</option>
            </select>
        </div>
        <div class="form-group">
            <label for="oncelik">Öncelik</label>
            <select name="oncelik" id="oncelik" class="form-control" required>
                <option value="dusuk">Düşük</option>
                <option value="orta">Orta</option>
                <option value="yuksek">Yüksek</option>
            </select>
        </div>
        <div class="form-group">
            <label for="aciklama">Açıklama</label>
            <textarea name="aciklama" id="aciklama" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="dosya">Dosya Ekle (İsteğe Bağlı)</label>
            <input type="file" name="dosya" id="dosya" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Oluştur</button>
    </form>
</div>

</body>
</html>