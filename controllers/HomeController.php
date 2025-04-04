<?php

require_once 'models/KullaniciModel.php';

class HomeController {

    private $kullaniciModel;

    public function __construct($db) {
        $this->kullaniciModel = new KullaniciModel($db);
    }

    public function giris() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email']; // "username" yerine "email" kullanıldı
            $password = $_POST['password'];

            $user = $this->kullaniciModel->getUserByEmail($email); // getUserByUsername() yerine getUserByEmail() kullanıldı

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: index.php?action=musteri-paneli');
                exit;
            } else {
                echo '<div class="alert alert-danger">E-posta veya şifre hatalı!</div>';
            }
        } else {
            require_once 'views/login.php';
        }
    }

    public function kayit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ad = $_POST['ad'];
            $soyad = $_POST['soyad'];
            $telefon = $_POST['telefon'];
            $email = $_POST['email'];
            $sifre = $_POST['password'];
            $sifre_tekrar = $_POST['sifre_tekrar'];

            // Veri doğrulama
            if (empty($ad) || empty($soyad) || empty($telefon) || empty($email) || empty($sifre) || empty($sifre_tekrar)) {
                $hata_mesaji = "Lütfen tüm alanları doldurun.";
                require_once 'views/kayit.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $hata_mesaji = "Geçersiz e-posta adresi.";
                require_once 'views/kayit.php';
                return;
            }

            if ($sifre !== $sifre_tekrar) {
                $hata_mesaji = "Şifreler eşleşmiyor.";
                require_once 'views/kayit.php';
                return;
            }

            if ($this->kullaniciModel->emailVarMi($email)) {
                $hata_mesaji = "Bu e-posta adresi zaten kayıtlı. Lütfen farklı bir e-posta adresi girin.";
                require_once 'views/kayit.php';
                return;
            }

            $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

            if ($this->kullaniciModel->createUser($ad, $soyad, $telefon, $email, $sifre_hash)) {
                $basari_mesaji = "Kayıt başarılı.";
            } else {
                $hata_mesaji = "Kayıt başarısız. Lütfen tekrar deneyin.";
            }
        }
        require_once 'views/kayit.php';
    }

    public function cikis() {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    // Diğer işlevler...
}

?>