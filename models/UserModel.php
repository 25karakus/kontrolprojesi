<?php

class UserModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM kullanicilar WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailVarMi($email) {
        $sql = "SELECT COUNT(*) FROM kullanicilar WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function createUser($username, $password, $email) {
        $sql = "INSERT INTO kullanicilar (username, password, email) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $password, $email]);
    }

    // Diğer işlevler...
}

?>