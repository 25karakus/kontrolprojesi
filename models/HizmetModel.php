<?php

class HizmetModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getHizmetlerByMusteriId($musteri_id) {
        $sql = "SELECT * FROM hizmetler WHERE musteri_id = :musteri_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':musteri_id', $musteri_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHizmetAdiById($hizmet_id) {
        $sql = "SELECT hizmet_adi FROM hizmetler WHERE id = :hizmet_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':hizmet_id', $hizmet_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['hizmet_adi'];
        } else {
            return null;
        }
    }

    // ... diğer metotlar ...
}

?>