<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php'; // config.php dosyasını dahil edin

// Model sınıflarının oluşturulması
$kullaniciModel = new KullaniciModel($db);

// Şifre sıfırlama anahtarını URL'den al
$sifre_sifirlama_anahtari = $_GET['anahtar'];

// Şifre sıfırlama anahtarını kullanarak kullanıcıyı veritabanında bul
$kullanici = $kullaniciModel->kullaniciBulSifreSifirlamaAnahtari($sifre_sifirlama_anahtari);

if (!$kullanici) {
    echo "Geçersiz şifre sıfırlama anahtarı.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $yeni_sifre = $_POST['yeni_sifre'];

    // Yeni şifreyi veritabanında güncelle
    try {
        $kullaniciModel->sifreGuncelle($kullanici['id'], $yeni_sifre);
    } catch (PDOException $e) {
        echo "Veritabanı Hatası: " . $e->getMessage();
        exit;
    }

    echo "Şifreniz başarıyla sıfırlandı.";
}

?>