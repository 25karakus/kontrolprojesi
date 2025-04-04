<?php

class SepetController {
    private $sepetModel;
    private $urunModel;
    private $db;

    public function __construct(SepetModel $sepetModel, UrunModel $urunModel, PDO $db) {
        $this->sepetModel = $sepetModel;
        $this->urunModel = $urunModel;
        $this->db = $db;
    }

    public function sepeteEkle() {
        $urunId = $_POST['urun_id'];
        $adet = $_POST['adet'];
        $kullaniciId = 1; // Örnek kullanıcı ID (oturum yönetimi ile değiştirin)

        if ($urunId > 0 && $adet > 0) {
            try {
                $sonuc = $this->sepetModel->sepeteEkle($kullaniciId, $urunId, $adet); // Doğru metot adı
                if ($sonuc) {
                    echo "Ürün sepete eklendi.";
                } else {
                    echo "Ürün sepete eklenirken veritabanı hatası oluştu.";
                }
            } catch (Exception $e) {
                echo "Sepete ürün eklenirken bir hata oluştu: " . $e->getMessage();
            }
        }
    }

    public function adetGuncelle() {
        $urunId = $_POST['guncelle_urun_id'];
        $adet = $_POST['guncelle_adet'];
        $kullaniciId = 1; // Örnek kullanıcı ID (oturum yönetimi ile değiştirin)

        if ($urunId > 0 && $adet > 0) {
            try {
                $sonuc = $this->sepetModel->adetGuncelle($_POST['sepet_id'], $kullaniciId, $adet); // Sepet ID'sini almayı unutmayın
                if ($sonuc) {
                    header('Location: index.php?action=sepet'); // Sepete geri yönlendir
                    exit;
                } else {
                    echo "Ürün adeti güncellenirken veritabanı hatası oluştu.";
                }
            } catch (Exception $e) {
                echo "Ürün adeti güncellenirken bir hata oluştu: " . $e->getMessage();
            }
        }
    }

    public function sepettenSil() {
        $sepetId = $_GET['sil_sepet_id']; // Sepet ID'sini al
        $kullaniciId = 1; // Örnek kullanıcı ID (oturum yönetimi ile değiştirin)

        if ($sepetId > 0) {
            try {
                $sonuc = $this->sepetModel->sepettenSil($sepetId, $kullaniciId);
                if ($sonuc) {
                    header('Location: index.php?action=sepet'); // Sepete geri yönlendir
                    exit;
                } else {
                    echo "Ürün sepetten silinirken veritabanı hatası oluştu.";
                }
            } catch (Exception $e) {
                echo "Ürün sepetten silinirken bir hata oluştu: " . $e->getMessage();
            }
        }
    }

    public function sepetiTemizle() {
        $kullaniciId = 1; // Örnek kullanıcı ID (oturum yönetimi ile değiştirin)
        try {
            $sonuc = $this->sepetModel->sepetiTemizle($kullaniciId);
            if ($sonuc) {
                header('Location: index.php?action=sepet'); // Sepete geri yönlendir
                exit;
            } else {
                echo "Sepet temizlenirken bir hata oluştu.";
            }
        } catch (Exception $e) {
            echo "Sepet temizlenirken bir hata oluştu: " . $e->getMessage();
        }
    }

    public function kuponKoduUygula() {
        $kuponKodu = $_POST['kupon_kodu'];
        $kullaniciId = 1; // Örnek kullanıcı ID (oturum yönetimi ile değiştirin)

        try {
            $sonuc = $this->sepetModel->kuponKoduUygula($kullaniciId, $kuponKodu);
            if ($sonuc) {
                echo "Kupon kodu uygulandı.";
            } else {
                echo "Kupon kodu uygulanamadı veya veritabanı hatası oluştu.";
            }
        } catch (Exception $e) {
            echo "Kupon kodu uygulanırken bir hata oluştu: " . $e->getMessage();
        }
    }

    public function hostingListesi() {
        // Ürün modelini kullanarak hosting ürünlerini getirin ve görüntüleyin
        $hostingUrunleri = $this->urunModel->getUrunlerByType('hosting');
        include 'views/hosting_listesi.php';
    }

    public function alanAdiListesi() {
        // Ürün modelini kullanarak alan adı ürünlerini getirin ve görüntüleyin
        $alanAdiUrunleri = $this->urunModel->getUrunlerByType('alan_adi');
        include 'views/alan_adi_listesi.php';
    }

    public function sepetiGoster() {
        if (isset($_SESSION['user_id'])) {
            $kullaniciId = $_SESSION['user_id'];
            $sepetUrunleri = $this->sepetModel->getSepet($kullaniciId); // Doğru metot adı
            include 'views/sepet.php'; // Sepet görünüm dosyasını dahil et
        } else {
            header('Location: index.php?action=giris');
            exit;
        }
    }
}

?>