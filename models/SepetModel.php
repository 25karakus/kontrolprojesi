<?php

class SepetModel {
    private $db; // mysqli yerine PDO türünde olacak

    public function __construct(PDO $db) { // PDO türünde bekleniyor
        $this->db = $db;
    }

    /**
     * Kullanıcının sepetindeki ürünleri getirir.
     *
     * @param int $kullaniciId Kullanıcı ID'si.
     * @return array Sepetteki ürünler veya boş dizi.
     */
    public function getSepet($kullaniciId) {
        $stmt = $this->db->prepare("SELECT s.id, s.urun_id, s.adet, u.ad AS urun_adi, u.fiyat AS urun_fiyati
                                   FROM sepet s
                                   INNER JOIN urunler u ON s.urun_id = u.id
                                   WHERE s.kullanici_id = ?");
        $stmt->execute([$kullaniciId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sepete yeni bir ürün ekler veya mevcut ürünün adedini artırır.
     *
     * @param int $kullaniciId Kullanıcı ID'si.
     * @param int $urunId Ürün ID'si.
     * @param int $adet Adet.
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function sepeteEkle($kullaniciId, $urunId, $adet = 1) {
        $sepetUrunu = $this->sepetUrunuVarMi($kullaniciId, $urunId);

        if ($sepetUrunu) {
            $yeniAdet = $sepetUrunu['adet'] + $adet;
            $stmt = $this->db->prepare("UPDATE sepet SET adet = ? WHERE kullanici_id = ? AND urun_id = ?");
            return $stmt->execute([$yeniAdet, $kullaniciId, $urunId]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO sepet (kullanici_id, urun_id, adet) VALUES (?, ?, ?)");
            return $stmt->execute([$kullaniciId, $urunId, $adet]);
        }
    }

    /**
     * Kullanıcının sepetinde belirli bir ürünün olup olmadığını kontrol eder.
     *
     * @param int $kullaniciId Kullanıcı ID'si.
     * @param int $urunId Ürün ID'si.
     * @return array|false Sepet ürünü bilgileri veya false.
     */
    public function sepetUrunuVarMi($kullaniciId, $urunId) {
        $stmt = $this->db->prepare("SELECT id, adet FROM sepet WHERE kullanici_id = ? AND urun_id = ?");
        $stmt->execute([$kullaniciId, $urunId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Sepetten bir ürünü siler.
     *
     * @param int $sepetId Sepet ID'si.
     * @param int $kullaniciId Kullanıcı ID'si (güvenlik için).
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function sepettenSil($sepetId, $kullaniciId) {
        $stmt = $this->db->prepare("DELETE FROM sepet WHERE id = ? AND kullanici_id = ?");
        return $stmt->execute([$sepetId, $kullaniciId]);
    }

    /**
     * Kullanıcının tüm sepetini temizler.
     *
     * @param int $kullaniciId Kullanıcı ID'si.
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function sepetiTemizle($kullaniciId) {
        $stmt = $this->db->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
        return $stmt->execute([$kullaniciId]);
    }

    /**
     * Sepetteki bir ürünün adedini günceller.
     *
     * @param int $sepetId Sepet ID'si.
     * @param int $kullaniciId Kullanıcı ID'si (güvenlik için).
     * @param int $adet Yeni adet.
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function adetGuncelle($sepetId, $kullaniciId, $adet) {
        $stmt = $this->db->prepare("UPDATE sepet SET adet = ? WHERE id = ? AND kullanici_id = ?");
        return $stmt->execute([$adet, $sepetId, $kullaniciId]);
    }

    /**
     * Belirli bir kullanıcı ve ürün için sepetteki adedi getirir.
     *
     * @param int $kullaniciId Kullanıcı ID'si.
     * @param int $urunId Ürün ID'si.
     * @return int Sepetteki adet veya 0.
     */
    public function getSepetAdet($kullaniciId, $urunId) {
        $stmt = $this->db->prepare("SELECT adet FROM sepet WHERE kullanici_id = ? AND urun_id = ?");
        $stmt->execute([$kullaniciId, $urunId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['adet'] : 0;
    }
}

?>