<?php

class MusteriModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMusteriIdByKullaniciId($kullanici_id) {
        $sql = "SELECT id FROM musteriler WHERE kullanici_id = :kullanici_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':kullanici_id', $kullanici_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['id'];
        } else {
            return null;
        }
    }

    public function getMusteriBilgileri($musteri_id) {
        $sql = "SELECT * FROM musteriler WHERE id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function musteriHizmetleri($musteri_id) {
        $sql = "SELECT * FROM hizmetler WHERE musteri_id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function musteriFaturalari($musteri_id) {
        $sql = "SELECT * FROM faturalar WHERE musteri_id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function musteriDestekTalepleri($musteri_id) {
        $sql = "SELECT * FROM destek_talepleri WHERE musteri_id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ... diğer metotlar ...
}

?>