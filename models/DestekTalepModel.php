<?php

class DestekTalepModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDestekTalepleriByMusteriId($musteri_id) {
        $sql = "SELECT * FROM destek_talepleri WHERE musteri_id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function yeniDestekTalebi($musteri_id, $baslik, $aciklama) {
        $sql = "INSERT INTO destek_talepleri (musteri_id, baslik, aciklama) VALUES (:musteri_id, :baslik, :aciklama)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->bindParam(':baslik', $baslik);
        $stmt->bindParam(':aciklama', $aciklama);
        return $stmt->execute();
    }

    // ... diğer metotlar ...
}

?>