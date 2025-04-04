<?php

// Veritabanı Bilgileri (DİKKAT: Hassas bilgiler doğrudan burada!)
define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', ''); // Eğer XAMPP'de şifre kullanmıyorsanız boş bırakın, aksi takdirde şifrenizi girin
define('DATABASE_NAME', 'verison3');

// PayTR Bilgileri (DİKKAT: Hassas bilgiler doğrudan burada!)
define('PAYTR_MERCHANT_ID', 'Sizin_Magaza_Numaraniz'); // Kendi mağaza numaranızı girin
define('PAYTR_MERCHANT_KEY', 'Sizin_PayTR_Anahtarınız'); // Kendi PayTR anahtarınızı girin
define('PAYTR_MERCHANT_SALT', 'Sizin_PayTR_Tuzunuz'); // Kendi PayTR tuzunuzu girin
define('PAYTR_OK_URL', 'https://siteniz.com/odeme-basarili.php'); // Kendi başarılı ödeme URL'nizi girin
define('PAYTR_FAIL_URL', 'https://siteniz.com/odeme-basarisiz.php'); // Kendi başarısız ödeme URL'nizi girin

// Veritabanı bağlantısını döndüren bir fonksiyon (isteğe bağlı)
function getDatabaseConnection() {
    global $db;
    return $db;
}

try {
    $db = new PDO("mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME . ";charset=utf8", DATABASE_USER, DATABASE_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Hata mesajını filtrele ve kullanıcıya gösterme
    error_log("Veritabanı bağlantısı başarısız: " . $e->getMessage());
    die("Veritabanı bağlantısı başarısız. Lütfen daha sonra tekrar deneyin.");
}

// Ortam değişkeni kontrollerini kaldırıyoruz
?>