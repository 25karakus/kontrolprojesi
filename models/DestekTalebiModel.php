<?php

class DestekTalebiModel {

    private $db;
    private $hataMesajlari = [];

    public function __construct($db) {
        $this->db = $db;
    }

    public function destekTalebiEkle($kullanici_id, $baslik, $aciklama) {
        if (empty($baslik) || empty($aciklama)) {
            $this->hataMesajlari[] = "Başlık ve açıklama boş olamaz.";
            return false;
        }

        try {
            $sql = "INSERT INTO destek_talepleri (kullanici_id, baslik, aciklama, olusturma_tarihi) VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([$kullanici_id, $baslik, $aciklama])) {
                return true;
            } else {
                $this->hataMesajlari[] = "Destek talebi eklenemedi: " . implode(" ", $stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function destekTalepleriniListele($kullanici_id) {
        try {
            $sql = "SELECT destek_talepleri.*, kullanicilar.username FROM destek_talepleri
                        INNER JOIN kullanicilar ON destek_talepleri.kullanici_id = kullanicilar.id
                        WHERE destek_talepleri.kullanici_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$kullanici_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function destekTalebiDetay($talep_id) {
        if (!isset($talep_id) || !is_numeric($talep_id)) {
            $this->hataMesajlari[] = "Geçersiz talep ID'si.";
            return false;
        }
        try {
            $sql = "SELECT destek_talepleri.*, kullanicilar.ad, kullanicilar.soyad
                        FROM destek_talepleri
                        INNER JOIN kullanicilar ON destek_talepleri.kullanici_id = kullanicilar.id
                        WHERE destek_talepleri.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$talep_id]);
            $talep = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$talep) {
                $this->hataMesajlari[] = "Destek talebi bulunamadı.";
                return false;
            }

            return $talep;
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function destekTalebiYanitlari($talep_id) {
        try {
            $sql = "SELECT destek_talebi_yanitlari.*, kullanicilar.username AS kullanici_ad
                        FROM destek_talebi_yanitlari
                        INNER JOIN kullanicilar ON destek_talebi_yanitlari.kullanici_id = kullanicilar.id
                        WHERE destek_talebi_yanitlari.talep_id = ?
                        ORDER BY destek_talebi_yanitlari.tarih ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$talep_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function yanitEkle($talep_id, $kullanici_id, $yanit) {
        if (empty($yanit)) {
            $this->hataMesajlari[] = "Yanıt boş olamaz.";
            return false;
        }

        try {
            $sql = "INSERT INTO destek_talebi_yanitlari (talep_id, kullanici_id, yanit, tarih) VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([$talep_id, $kullanici_id, $yanit])) {
                return true;
            } else {
                $this->hataMesajlari[] = "Yanıt eklenemedi: " . implode(" ", $stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function yorumEkle($talep_id, $kullanici_id, $yorum) {
        if (empty($yorum)) {
            $this->hataMesajlari[] = "Yorum boş olamaz.";
            return false;
        }

        try {
            $sql = "INSERT INTO destek_talebi_yorumları (talep_id, kullanici_id, yorum, tarih) VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            if ($stmt->execute([$talep_id, $kullanici_id, $yorum])) {
                return true;
            } else {
                $this->hataMesajlari[] = "Yorum eklenemedi: " . implode(" ", $stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function destekTalebiYorumlari($talep_id) {
        try {
            $sql = "SELECT destek_talebi_yorumları.*, kullanicilar.username AS kullanici_ad
                        FROM destek_talebi_yorumları
                        INNER JOIN kullanicilar ON destek_talebi_yorumları.kullanici_id = kullanicilar.id
                        WHERE destek_talebi_yorumları.talep_id = ?
                        ORDER BY destek_talebi_yorumları.tarih ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$talep_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->hataMesajlari[] = "Veritabanı hatası: " . $e->getMessage();
            return false;
        }
    }

    public function hataMesajlari() {
        return $this->hataMesajlari;
    }
}

?>