<?php

class FaturaModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getFaturalarByMusteriId($musteri_id) {
        $sql = "SELECT * FROM faturalar WHERE musteri_id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ... diğer metotlar ...
}

?>