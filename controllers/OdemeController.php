<?php
class OdemeController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function odemeFormu() {
        if (isset($_SESSION['user_id'])) {
            $kullaniciId = $_SESSION['user_id'];
            $sepetModel = new SepetModel($this->db);
            $sepet = $sepetModel->kullaniciSepetiGetir($kullaniciId);
            require_once 'views/odeme_formu.php';
        } else {
            echo "Ödeme sayfasına erişmek için giriş yapmanız gerekiyor.";
        }
    }

    public function odemeYap() {
        // Ödeme işlemlerini burada gerçekleştirin
        // ...

        // Sepeti temizle
        $sepetModel = new SepetModel($this->db);
        $sepetModel->sepetiTemizle($_SESSION['user_id']);

        echo "Ödeme başarıyla tamamlandı!";
    }
}
?>