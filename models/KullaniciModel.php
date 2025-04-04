<?php

class KullaniciModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * E-posta adresine göre kullanıcı bilgilerini getirir.
     *
     * @param string $email Kullanıcının e-posta adresi.
     * @return array|false Kullanıcı bilgileri veya false.
     */
    public function kullaniciBulEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM kullanicilar WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kullanıcının şifre sıfırlama anahtarını ve son kullanma tarihini günceller.
     *
     * @param int $id Kullanıcının ID'si.
     * @param string $sifre_sifirlama_anahtari Şifre sıfırlama anahtarı.
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function sifreSifirlamaAnahtariGuncelle($id, $sifre_sifirlama_anahtari) {
        $stmt = $this->db->prepare("UPDATE kullanicilar SET sifre_sifirlama_anahtari = ?, sifre_sifirlama_anahtari_son_kullanma = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?");
        return $stmt->execute([$sifre_sifirlama_anahtari, $id]);
    }

    /**
     * Şifre sıfırlama anahtarına göre kullanıcı bilgilerini getirir.
     *
     * @param string $sifre_sifirlama_anahtari Şifre sıfırlama anahtarı.
     * @return array|false Kullanıcı bilgileri veya false.
     */
    public function kullaniciBulSifreSifirlamaAnahtari($sifre_sifirlama_anahtari) {
        $stmt = $this->db->prepare("SELECT * FROM kullanicilar WHERE sifre_sifirlama_anahtari = ? AND sifre_sifirlama_anahtari_son_kullanma > NOW()");
        $stmt->execute([$sifre_sifirlama_anahtari]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kullanıcının şifresini günceller.
     *
     * @param int $id Kullanıcının ID'si.
     * @param string $yeni_sifre Yeni şifre.
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function sifreGuncelle($id, $yeni_sifre) {
        $stmt = $this->db->prepare("UPDATE kullanicilar SET password = ?, sifre_sifirlama_anahtari = NULL, sifre_sifirlama_anahtari_son_kullanma = NULL WHERE id = ?");
        return $stmt->execute([password_hash($yeni_sifre, PASSWORD_DEFAULT), $id]);
    }

    /**
     * Belirtilen e-posta adresinin veritabanında var olup olmadığını kontrol eder.
     *
     * @param string $email Kontrol edilecek e-posta adresi.
     * @return bool E-posta adresi varsa true, yoksa false.
     */
    public function emailVarMi($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM kullanicilar WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Yeni bir kullanıcı oluşturur.
     *
     * @param string $ad Kullanıcının adı.
     * @param string $soyad Kullanıcının soyadı.
     * @param string $telefon Kullanıcının telefon numarası.
     * @param string $email Kullanıcının e-posta adresi.
     * @param string $sifre_hash Kullanıcının şifresinin hash'i.
     * @return bool İşlem başarılıysa true, başarısızsa false.
     */
    public function createUser($ad, $soyad, $telefon, $email, $sifre_hash) {
        // Telefon numarasını temizle ve doğrula
        $telefon = preg_replace('/\D/', '', $telefon); // Sadece rakamları al
        if (strlen($telefon) !== 10) { // 10 haneli telefon numarası kontrolü (örnek)
            return false; // Geçersiz telefon numarası
        }

        $stmt = $this->db->prepare("INSERT INTO kullanicilar (ad, soyad, telefon, email, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$ad, $soyad, $telefon, $email, $sifre_hash]);
    }

    /**
     * E-posta adresine göre kullanıcı bilgilerini getirir.
     *
     * @param string $email Kullanıcının e-posta adresi.
     * @return array|false Kullanıcı bilgileri veya false.
     */
    public function getUserByEmail($email) {
        return $this->kullaniciBulEmail($email); // Mevcut metodu kullan
    }
}

?>