<?php

class UrunModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function urunGetir($id) {
        $stmt = $this->db->prepare("SELECT * FROM urunler WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function urunleriGetir($tur) {
        $stmt = $this->db->prepare("SELECT * FROM urunler WHERE tur = ?");
        $stmt->execute([$tur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>