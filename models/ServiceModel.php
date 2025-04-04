<?php

require_once 'config.php';

class ServiceModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getServicesByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServiceById($serviceId) {
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->execute([$serviceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function assignServiceToUser($serviceId, $userId) {
        $stmt = $this->db->prepare("UPDATE services SET user_id = ? WHERE id = ?");
        $stmt->execute([$userId, $serviceId]);
    }

    // Diğer hizmet işlemleri...
}

?>