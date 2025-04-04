<!DOCTYPE html>
<html>
<head>
    <title>Sepetiniz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Sepetiniz</h2>
        <?php if (!empty($sepet)): ?>
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ürün</th>
                                <th>Adet</th>
                                <th>Fiyat</th>
                                <th>Toplam</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $toplam_fiyat = 0;
                            foreach ($sepet as $urun):
                                $toplam = $urun['adet'] * $urun['fiyat'];
                                $toplam_fiyat += $toplam;
                            ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $urun['resim_url']; ?>" alt="<?php echo $urun['ad']; ?>" width="50">
                                        <?php echo $urun['ad']; ?>
                                        <p><?php echo $urun['aciklama']; ?></p>
                                    </td>
                                    <td>
                                        <div class="adet-kontrol">
                                            <button class="adet-azalt" data-id="<?php echo $urun['id']; ?>">-</button>
                                            <input type="number" value="<?php echo $urun['adet']; ?>" min="1" class="adet-input" data-id="<?php echo $urun['id']; ?>">
                                            <button class="adet-arttir" data-id="<?php echo $urun['id']; ?>">+</button>
                                        </div>
                                    </td>
                                    <td><?php echo $urun['fiyat']; ?> TL</td>
                                    <td class="urun-toplam" data-id="<?php echo $urun['id']; ?>"><?php echo $toplam; ?> TL</td>
                                    <td><a href="index.php?action=sepet-sil&id=<?php echo $urun['id']; ?>" class="btn btn-danger btn-sm">Sil</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-3">
                        <h4>Toplam Tutar: <span id="toplam-tutar"><?php echo $toplam_fiyat; ?></span> TL</h4>
                        <div class="kupon-kodu">
                            <input type="text" id="kupon-kodu-input" placeholder="Kupon Kodu">
                            <button id="kupon-kodu-uygula" class="btn btn-primary btn-sm">Uygula</button>
                        </div>
                        <a href="index.php?action=alisveris-tamamla" class="btn btn-primary btn-block">Ödeme Sayfasına Devam Et</a>
                        <a href="index.php?action=sepet-temizle" class="btn btn-warning btn-block">Sepeti Temizle</a>
                        <a href="index.php?action=hizmetler" class="btn btn-secondary btn-block">Alışverişe Devam Et</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p>Sepetiniz boş.</p>
        <?php endif; ?>
        <div id="hata-mesaji" class="alert alert-danger" style="display: none;"></div>
    </div>

    <script>
        // Adet güncelleme işlemleri
        const adetInputs = document.querySelectorAll('.adet-input');
        adetInputs.forEach(input => {
            input.addEventListener('change', function() {
                const urunId = this.dataset.id;
                const adet = this.value;
                guncelleAdet(urunId, adet);
            });
        });

        const adetArttirButonlari = document.querySelectorAll('.adet-arttir');
        adetArttirButonlari.forEach(button => {
            button.addEventListener('click', function() {
                const urunId = this.dataset.id;
                const input = document.querySelector(`.adet-input[data-id="${urunId}"]`);
                input.value = parseInt(input.value) + 1;
                guncelleAdet(urunId, input.value);
            });
        });

        const adetAzaltButonlari = document.querySelectorAll('.adet-azalt');
        adetAzaltButonlari.forEach(button => {
            button.addEventListener('click', function() {
                const urunId = this.dataset.id;
                const input = document.querySelector(`.adet-input[data-id="${urunId}"]`);
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    guncelleAdet(urunId, input.value);
                }
            });
        });

        function guncelleAdet(urunId, adet) {
            fetch('index.php?action=adet-guncelle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `urun_id=${urunId}&adet=${adet}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('toplam-tutar').textContent = data.toplam_tutar;
                    document.querySelector(`.urun-toplam[data-id="${urunId}"]`).textContent = `${adet * data.urun_fiyat} TL`;
                } else {
                    document.getElementById('hata-mesaji').textContent = data.message;
                    document.getElementById('hata-mesaji').style.display = 'block';
                }
            });
        }

        // Kupon kodu uygulama işlemleri
        document.getElementById('kupon-kodu-uygula').addEventListener('click', function() {
            const kuponKodu = document.getElementById('kupon-kodu-input').value;
            fetch('index.php?action=kupon-kodu-uygula', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `kupon_kodu=${kuponKodu}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('toplam-tutar').textContent = data.toplam_tutar;
                } else {
                    document.getElementById('hata-mesaji').textContent = data.message;
                    document.getElementById('hata-mesaji').style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>