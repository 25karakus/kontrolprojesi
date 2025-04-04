<?php

class EpostaAyarlariModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function epostaAyarlariGetir() {
        $stmt = $this->db->prepare("SELECT * FROM eposta_ayarlari LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>