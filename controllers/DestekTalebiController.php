<?php

require_once 'models/DestekTalebiModel.php';

class DestekTalebiController {

    private $destekTalebiModel;

    public function __construct($db) {
        $this->destekTalebiModel = new DestekTalebiModel($db);
    }

    public function destekTalebiOlustur() {
        if (isset($_POST['baslik']) && isset($_POST['aciklama'])) {
            $baslik = filter_var($_POST['baslik'], FILTER_SANITIZE_STRING);
            $aciklama = filter_var($_POST['aciklama'], FILTER_SANITIZE_STRING);
            $kullanici_id = $_SESSION['user_id'];

            if (empty($baslik) || empty($aciklama)) {
                echo "<p>Başlık ve açıklama boş olamaz.</p>";
                return;
            }

            try {
                if ($this->destekTalebiModel->destekTalebiEkle($kullanici_id, $baslik, $aciklama)) {
                    header('Location: index.php?action=destek-talepleri');
                    exit;
                } else {
                    $hataMesajlari = $this->destekTalebiModel->hataMesajlari();
                    foreach ($hataMesajlari as $hata) {
                        echo "<p>Hata: " . htmlspecialchars($hata) . "</p>";
                    }
                }
            } catch (Exception $e) {
                echo "<p>Destek talebi oluşturulamadı. Lütfen tekrar deneyin.</p>";
                error_log("Destek talebi oluşturma hatası: " . $e->getMessage());
            }
        } else {
            echo "<p>Destek talebi oluşturma başarısız. Lütfen tüm alanları doldurun.</p>";
        }
    }

    public function destekTalepleri() {
        $kullanici_id = $_SESSION['user_id'];
        $destek_talepleri = $this->destekTalebiModel->destekTalepleriniListele($kullanici_id);
        include 'views/musteri-paneli/destek_talepleri.php';
    }

    public function destekTalebiDetay() {
        if (isset($_GET['id'])) {
            $talep_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            if (!is_numeric($talep_id) || $talep_id <= 0) {
                echo "<p>Geçersiz talep ID'si.</p>";
                return;
            }

            $talep = $this->destekTalebiModel->destekTalebiDetay($talep_id);
            $yanitlar = $this->destekTalebiModel->destekTalebiYanitlari($talep_id);
            $yorumlar = $this->destekTalebiModel->destekTalebiYorumlari($talep_id);

            if ($talep) {
                include 'views/musteri-paneli/destek_talebi_detay.php';
            } else {
                $hataMesajlari = $this->destekTalebiModel->hataMesajlari();
                if (!empty($hataMesajlari)) {
                    foreach ($hataMesajlari as $hata) {
                        echo "<p>Hata: " . htmlspecialchars($hata) . "</p>";
                    }
                } else {
                    echo "<p>Destek talebi bulunamadı.</p>";
                }
            }
        } else {
            echo "<p>Destek talebi bulunamadı.</p>";
        }
    }

    public function yanitEkle() {
        if (isset($_GET['id']) && isset($_POST['yanit'])) {
            $talep_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $yanit = filter_var($_POST['yanit'], FILTER_SANITIZE_STRING);
            $kullanici_id = $_SESSION['user_id'];

            if (empty($yanit)) {
                echo "<p>Yanıt boş olamaz.</p>";
                return;
            }

            try {
                if ($this->destekTalebiModel->yanitEkle($talep_id, $kullanici_id, $yanit)) {
                    header('Location: index.php?action=destek-talebi-detay&id=' . $talep_id);
                    exit;
                } else {
                    $hataMesajlari = $this->destekTalebiModel->hataMesajlari();
                    foreach ($hataMesajlari as $hata) {
                        echo "<p>Hata: " . htmlspecialchars($hata) . "</p>";
                    }
                }
            } catch (Exception $e) {
                echo "<p>Yanıt eklenemedi. Lütfen tekrar deneyin.</p>";
                error_log("Yanıt eklenemedi: " . $e->getMessage());
            }
        } else {
            echo "<p>Yanıt ekleme başarısız. Lütfen yanıtınızı girin.</p>";
        }
    }

    public function yorumEkle() {
        if (isset($_GET['id']) && isset($_POST['yorum'])) {
            $talep_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            $yorum = filter_var($_POST['yorum'], FILTER_SANITIZE_STRING);
            $kullanici_id = $_SESSION['user_id'];

            if (empty($yorum)) {
                echo "<p>Yorum boş olamaz.</p>";
                return;
            }

            try {
                if ($this->destekTalebiModel->yorumEkle($talep_id, $kullanici_id, $yorum)) {
                    header('Location: index.php?action=destek-talebi-detay&id=' . $talep_id);
                    exit;
                } else {
                    $hataMesajlari = $this->destekTalebiModel->hataMesajlari();
                    foreach ($hataMesajlari as $hata) {
                        echo "<p>Hata: " . htmlspecialchars($hata) . "</p>";
                    }
                }
            } catch (Exception $e) {
                echo "<p>Yorum eklenemedi. Lütfen tekrar deneyin.</p>";
                error_log("Yorum eklenemedi: " . $e->getMessage());
            }
        } else {
            echo "<p>Yorum ekleme başarısız. Lütfen yorumunuzu girin.</p>";
        }
    }
}

?>