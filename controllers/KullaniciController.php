<?php

require 'vendor/autoload.php';
require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class KullaniciController {
    private $model;
    private $epostaAyarlariModel;
    private $db;

    public function __construct($model, $epostaAyarlariModel, $db) {
        $this->model = $model;
        $this->epostaAyarlariModel = $epostaAyarlariModel;
        $this->db = $db;
    }

    public function sifremiUnuttum() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $kullanici = $this->model->kullaniciBulEmail($email);

            if ($kullanici) {
                $sifre_sifirlama_anahtari = bin2hex(random_bytes(32));
                $this->model->sifreSifirlamaAnahtariGuncelle($kullanici['id'], $sifre_sifirlama_anahtari);

                $epostaAyarlari = $this->epostaAyarlariModel->epostaAyarlariGetir();

                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Hata ayıklamayı etkinleştirin
                    $mail->isSMTP();
                    $mail->Host       = $epostaAyarlari['smtp_sunucu'];
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $epostaAyarlari['smtp_kullanici_adi'];
                    $mail->Password   = $epostaAyarlari['smtp_sifre'];
                    $mail->SMTPSecure = $epostaAyarlari['smtp_guvenlik'];
                    $mail->Port       = $epostaAyarlari['smtp_port'];

                    $mail->setFrom($epostaAyarlari['gonderen_eposta'], $epostaAyarlari['gonderen_ad']);
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Şifre Sıfırlama';
                    $mail->Body    = 'Şifrenizi sıfırlamak için lütfen bu bağlantıya tıklayın: <a href="index.php?action=sifreSifirlamaFormu&anahtar=' . $sifre_sifirlama_anahtari . '">Şifre Sıfırlama</a>';

                    if ($mail->send()) {
                        echo 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.<br>';
                    } else {
                        echo "E-posta gönderilemedi. Hata: " . $mail->ErrorInfo . "<br>";
                    }
                } catch (Exception $e) {
                    echo "E-posta gönderilemedi. Hata: " . $e->getMessage() . "<br>";
                    error_log($e->getMessage());
                }
            } else {
                echo "Bu e-posta adresine kayıtlı bir kullanıcı bulunamadı.<br>";
            }
        } else {
            require_once 'views/musteri-paneli/sifremi_unuttum.php';
        }
    }

    public function sifreSifirlamaFormu() {
        $sifre_sifirlama_anahtari = $_GET['anahtar'];
        $kullanici = $this->model->kullaniciBulSifreSifirlamaAnahtari($sifre_sifirlama_anahtari);

        if (!$kullanici) {
            echo "Geçersiz şifre sıfırlama anahtarı.<br>";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $yeni_sifre = $_POST['yeni_sifre'];
            if ($this->model->sifreGuncelle($kullanici['id'], $yeni_sifre)) {
                echo "Şifreniz başarıyla sıfırlandı. Giriş yapabilirsiniz.<br>";
            } else {
                echo "Şifre sıfırlama işlemi başarısız oldu. Lütfen daha sonra tekrar deneyin.<br>";
            }
        } else {
            require_once 'views/musteri-paneli/sifre_sifirlama_formu.php';
        }
    }
}

?>