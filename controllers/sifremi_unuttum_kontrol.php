<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
require_once 'config.php'; // config.php dosyasını dahil edin

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Model sınıflarının oluşturulması
$kullaniciModel = new KullaniciModel($db);
$epostaAyarlariModel = new EpostaAyarlariModel($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Kullanıcıyı e-posta adresine göre veritabanında bul
    $kullanici = $kullaniciModel->kullaniciBulEmail($email);

    if ($kullanici) {
        // Şifre sıfırlama anahtarı oluştur
        $sifre_sifirlama_anahtari = bin2hex(random_bytes(32));

        // Şifre sıfırlama anahtarını ve son kullanma tarihini veritabanına kaydet
        try {
            $kullaniciModel->sifreSifirlamaAnahtariGuncelle($kullanici['id'], $sifre_sifirlama_anahtari);
        } catch (PDOException $e) {
            echo "Veritabanı Hatası: " . $e->getMessage();
            exit;
        }

        // E-posta ayarlarını veritabanından al
        $epostaAyarlari = $epostaAyarlariModel->epostaAyarlariGetir();

        // PHPMailer ile e-posta gönder
        $mail = new PHPMailer(true);
        try {
            // Sunucu ayarları
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Hata ayıklama etkinleştirildi
            $mail->isSMTP();
            $mail->Host       = $epostaAyarlari['smtp_sunucu'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $epostaAyarlari['smtp_kullanici_adi'];
            $mail->Password   = $epostaAyarlari['smtp_sifre'];
            $mail->SMTPSecure = $epostaAyarlari['smtp_guvenlik'];
            $mail->Port       = $epostaAyarlari['smtp_port'];

            // Alıcılar
            $mail->setFrom($epostaAyarlari['gonderen_eposta'], $epostaAyarlari['gonderen_ad']);
            $mail->addAddress($email);

            // İçerik
            $mail->isHTML(true);
            $mail->Subject = 'Şifre Sıfırlama';
            $mail->Body    = 'Şifrenizi sıfırlamak için lütfen bu bağlantıya tıklayın: <a href="index.php?action=sifreSifirlamaFormu&anahtar=' . $sifre_sifirlama_anahtari . '">Şifre Sıfırlama</a>';

            $mail->send();
            echo 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
        } catch (Exception $e) {
            echo "E-posta gönderilemedi. Hata: {$mail->ErrorInfo}";
        }
    } else {
        echo "Bu e-posta adresine kayıtlı bir kullanıcı bulunamadı.";
    }
}

?>