<?php

require_once 'models/ServiceModel.php';

class ServicesController {

    private $serviceModel;

    public function __construct() {
        global $db;
        $this->serviceModel = new ServiceModel($db);
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $services = $this->serviceModel->getServicesByUserId($userId);

        require_once 'views/services.php';
    }

    public function detail() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $serviceId = $_GET['id'];
        $service = $this->serviceModel->getServiceById($serviceId);

        require_once 'views/service_detail.php';
    }

    public function buy() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $serviceId = $_POST['service_id'];
        $userId = $_SESSION['user_id'];
        $service = $this->serviceModel->getServiceById($serviceId);

        // PayTR API Bilgileri
        $merchant_id = PAYTR_MERCHANT_ID;
        $merchant_key = PAYTR_MERCHANT_KEY;
        $merchant_salt = PAYTR_MERCHANT_SALT;

        // Sipariş Bilgileri
        $email = 'musteri@eposta.com'; // Müşteri e-posta adresi
        $payment_amount = $service['price'] * 100; // Ödeme tutarı (kuruş cinsinden)
        $merchant_oid = uniqid(); // Eşsiz sipariş numarası
        $user_ip = $_SERVER['REMOTE_ADDR']; // Müşteri IP adresi
        $user_basket = base64_encode(json_encode(array(array("Hizmet Adı", $service['price'], 1)))); // Sepet bilgileri
        $ok_url = PAYTR_OK_URL; // Ödeme başarılı URL
        $fail_url = PAYTR_FAIL_URL; // Ödeme başarısız URL

        // Hash Oluşturma
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $ok_url . $fail_url . $merchant_salt;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));

        // PayTR API'sine Gönderilecek Veriler
        $post_vals = array(
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'user_basket' => $user_basket,
            'paytr_token' => $paytr_token,
            'debug_on' => 1,
            'test_mode' => 1,
            'no_installment' => 1,
            'max_installment' => 0,
            'lang' => 'tr',
            'ok_url' => $ok_url,
            'fail_url' => $fail_url
        );

        // PayTR API'sine POST İstek Gönderme
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, 1);

        if ($result['status'] == 'success') {
            $token = $result['token'];
            header("Location: https://www.paytr.com/odeme/api/pay?token=" . $token);
        } else {
            echo "PayTR hatası: " . $result['reason'];
        }
    }

    public function assignServiceToUser($serviceId, $userId) {
        $stmt = $this->db->prepare("UPDATE services SET user_id = ? WHERE id = ?");
        $stmt->execute([$userId, $serviceId]);
    }

     // Hizmet Silme İşlemi
     public function deleteService(){
      if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?action=login');
        exit;
      }
      $serviceId = $_GET['id'];
      $stmt = $this->db->prepare("DELETE FROM services WHERE id = ?");
      $stmt->execute([$serviceId]);

      header('Location: index.php?action=services');
      exit;
     }

    // Hizmet Ekleme İşlemi
    public function addService(){
      if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?action=login');
        exit;
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $name = $_POST['name'];
          $price = $_POST['price'];
          $description = $_POST['description'];

          $stmt = $this->db->prepare("INSERT INTO services (name, price, description) VALUES (?, ?, ?)");
          $stmt->execute([$name, $price, $description]);

          header('Location: index.php?action=services');
          exit;
      }

      require_once 'views/add_service.php';
    }

    // Hizmet Güncelleme İşlemi
    public function updateService(){
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceId = $_POST['service_id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];

            $stmt = $this->db->prepare("UPDATE services SET name = ?, price = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $price, $description, $serviceId]);

            header('Location: index.php?action=services');
            exit;
        }

        $serviceId = $_GET['id'];
        $service = $this->serviceModel->getServiceById($serviceId);

        require_once 'views/update_service.php';
    }

    // Diğer hizmet işlemleri...
}

?>