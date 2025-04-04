<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'config.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/ServicesController.php';
require_once 'controllers/MusteriPanelController.php';
require_once 'controllers/DestekTalebiController.php';
require_once 'controllers/KullaniciController.php';
require_once 'controllers/SepetController.php';
require_once 'controllers/OdemeController.php';
require_once 'models/KullaniciModel.php';
require_once 'models/EpostaAyarlariModel.php';
require_once 'models/UrunModel.php';
require_once 'models/SepetModel.php';

require_once 'views/header.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'anasayfa';

try {
    // PDO bağlantısı oluştur
    $db = new PDO("mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME . ";charset=utf8", DATABASE_USER, DATABASE_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $homeController = new HomeController($db);
    $servicesController = new ServicesController($db);
    $musteriPanelController = new MusteriPanelController($db);
    $destekTalebiController = new DestekTalebiController($db);
    $kullaniciModel = new KullaniciModel($db);
    $epostaAyarlariModel = new EpostaAyarlariModel($db);
    $kullaniciController = new KullaniciController($kullaniciModel, $epostaAyarlariModel, $db);
    $urunModel = new UrunModel($db);
    $sepetModel = new SepetModel($db);
    $sepetController = new SepetController($sepetModel, $urunModel, $db);
    $odemeController = new OdemeController($db);

    switch ($action) {
        case 'giris':
        case 'cikis':
        case 'kayit':
            $homeController->$action();
            break;
        case 'hizmetler':
            $servicesController->index();
            break;
        case 'hizmet-detay':
            $servicesController->detail();
            break;
        case 'hizmet-satinal':
            $servicesController->buy();
            break;
        case 'hizmet-sil':
            $servicesController->deleteService();
            break;
        case 'hizmet-ekle':
            $servicesController->addService();
            break;
        case 'hizmet-guncelle':
            $servicesController->updateService();
            break;
        case 'musteri-paneli':
            $musteriPanelController->anasayfa();
            break;
        case 'musteri-hizmetler':
            $musteriPanelController->hizmetler();
            break;
        case 'musteri-faturalar':
            $musteriPanelController->faturalar();
            break;
        case 'sifremiUnuttum':
            $kullaniciController->sifremiUnuttum();
            break;
        case 'sifreSifirlamaFormu':
            $kullaniciController->sifreSifirlamaFormu();
            break;
        case 'destek-talebi-olustur':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $destekTalebiController->destekTalebiOlustur();
            } else {
                require_once 'views/musteri-paneli/destek_talebi_olustur.php';
            }
            break;
        case 'destek-talepleri':
            $destekTalebiController->destekTalepleri();
            break;
        case 'destek-talebi-detay':
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $destekTalebiController->destekTalebiDetay();
            } else {
                echo "Geçersiz destek talebi ID'si.";
            }
            break;
        case 'yorum-ekle':
            $destekTalebiController->yorumEkle();
            break;
        case 'yanit-ekle':
            $destekTalebiController->yanitEkle();
            break;
        case 'hosting-listesi':
            $sepetController->hostingListesi();
            break;
        case 'alan-adi-listesi':
            $sepetController->alanAdiListesi();
            break;
        case 'sepet-ekle':
            $sepetController->sepeteEkle();
            break;
        case 'sepet':
            $sepetController->sepetiGoster(); // Düzeltilmiş metot adı
            break;
        case 'sepet-sil':
            $sepetController->sepettenSil();
            break;
        case 'sepet-temizle':
            $sepetController->sepetiTemizle();
            break;
        case 'odeme-yap':
            $odemeController->odemeYap();
            break;
        case 'adet-guncelle':
            $sepetController->adetGuncelle();
            break;
        case 'anasayfa':
        default:
            $icerik = '
                <div class="slider-container">
                    <div class="slider">
                        <div class="slide">
                            <img src="views/images/slider1.jpg" alt="Slider 1">
                            <div class="slide-content">
                                <h2>Hızlı ve Güvenilir Hosting</h2>
                                <p>Web siteniz için en iyi hosting çözümleri.</p>
                                <a href="index.php?action=hizmetler" class="btn btn-primary">Hizmetlerimizi İnceleyin</a>
                            </div>
                        </div>
                        <div class="slide">
                            <img src="views/images/slider2.jpg" alt="Slider 2">
                            <div class="slide-content">
                                <h2>Uygun Fiyatlı Alan Adı Kaydı</h2>
                                <p>Popüler alan adı uzantılarıyla web adresinizi alın.</p>
                                <a href="index.php?action=kayit" class="btn btn-success">Alan Adı Alın</a>
                            </div>
                        </div>
                        <div class="slide">
                            <img src="views/images/slider3.jpg" alt="Slider 3">
                            <div class="slide-content">
                                <h2>7/24 Teknik Destek</h2>
                                <p>Uzman ekibimiz her zaman yanınızda.</p>
                                <a href="index.php?action=destek-talebi-olustur" class="btn btn-info">Destek Alın</a>
                            </div>
                        </div>
                    </div>
                    <div class="slider-controls">
                        <button class="prev-slide"><i class="fas fa-chevron-left"></i></button>
                        <button class="next-slide"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="container-fluid mt-5">
                    <div class="jumbotron">
                        <h1 class="display-4 text-center">Hosting ve Alan Adı Hizmetleri</h1>
                        <p class="lead text-center">Web siteniz için en iyi hosting ve alan adı çözümleri burada!</p>
                        <hr class="my-4">
                        <p class="text-center">Hızlı, güvenilir ve uygun fiyatlı hosting paketlerimizle tanışın.</p>
                        ';
            if (isset($_SESSION['user_id'])) {
                $icerik .= '<div class="text-center"><a class="btn btn-primary btn-lg" href="index.php?action=hizmetler" role="button">Hizmetlerimizi İnceleyin</a></div>';
            } else {
                $icerik .= '<div class="text-center"><a class="btn btn-primary btn-lg" href="index.php?action=giris" role="button">Giriş Yap</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a class="btn btn-success btn-lg" href="index.php?action=kayit" role="button">Kayıt Ol</a></div>';
            }
            $icerik .= '
                    </div>

                    <div class="mt-5 text-center">
                        <h2 class="mb-4">NEDEN HOSTINGSTOR?</h2>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-4 text-center feature-box">
                            <i class="fas fa-server fa-3x mb-3"></i>
                            <h3>Güçlü Performans</h3>
                            <p>Kullandığımız donanımların hepsi son nesil olmakla birlikte sunucularımızda güçlü performans garantisi vermekteyiz.</p>
                        </div>
                        <div class="col-md-4 text-center feature-box">
                            <i class="fas fa-shield-alt fa-3x mb-3"></i>
                            <h3>Virüs Koruması</h3>
                            <p>Sunucularımızda Imunify360 yazılımı sürekli çalıştığı için web siteleriniz anlık olarak korunmaktadır.</p>
                        </div>
                        <div class="col-md-4 text-center feature-box">
                            <i class="fas fa-truck fa-3x mb-3"></i>
                            <h3>Ücretsiz Taşıma</h3>
                            <p>cPanelden cPanele ücretsiz olarak aktarım sağlamaktayız.</p>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-4 text-center feature-box">
                            <i class="fas fa-sync-alt fa-3x mb-3"></i>
                            <h3>Düzenli Yedek</h3>
                            <p>Kullandığımız yazılımla birlikte haftalık olarak farklı bir yedek sunucusunda yedekleriniz korunmaktadır.</p>
                        </div>
                        <div class="col-md-4 text-center feature-box">
                            <i class="fas fa-headset fa-3x mb-3"></i>
                            <h3>7/24 Teknik Destek</h3>
                            <p>RegBilisim ekibi olarak 7 gün 24 saat boyunca herhangi bir sorun yaşamanız durumunda sizlere yardımcı olmaktayız.</p>
                        </div>
                        <div class="col-md-4 text-center feature-box">
                            <i class="fas fa-envelope-open-text fa-3x mb-3"></i>
                            <h3>Güvenli E-Posta</h3>
                            <p>Sistemlerimiz spam veya virüs içerikli gönderileri engelleyerek temiz ve kaliteli e-posta çözümleri sağlamaktadır.</p>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <h2 class="mb-4">Tüm Hizmetlerimiz</h2>
                        <p>RegBilisim olarak verdiğimiz tüm hizmetlerimiz aşağıda listelenmektedir.</p>

                        <div class="row justify-content-center">
                            <div class="col-md-3 service-box">
                                <h3>Linux Web Hosting</h3>
                                <p>Web siteniz için yüksek performanslı hosting paketlerimiz.</p>
                                <div class="text-center"><a href="index.php?action=hizmet-detay&id=1" class="btn btn-primary">Detaylı İncele</a></div>
                            </div>
                            <div class="col-md-3 service-box">
                                <h3>VDS Sunucu (Sanal Sunucu)</h3>
                                <p>Özenle seçilmiş donanımlar ile yüksek performanslı VDS sunucularımız.</p>
                                <div class="text-center"><a href="index.php?action=hizmet-detay&id=2" class="btn btn-primary">Detaylı İncele</a></div>
                            </div>
                            <div class="col-md-3 service-box">
                                <h3>Sunucu Barındırma</h3>
                                <p>Co-location hizmetimiz ile sunucularınızı güvenle barındırabilirsiniz.</p>
                                <div class="text-center"><a href="index.php?action=hizmet-detay&id=3" class="btn btn-primary">Detaylı İncele</a></div>
                            </div>
                            <div class="col-md-3 service-box">
                                <h3>Oyun Sunucuları</h3>
                                <p>En popüler oyun sunucuları için yüksek performanslı hizmetlerimiz.</p>
                                <div class="text-center"><a href="index.php?action=hizmet-detay&id=4" class="btn btn-primary">Detaylı İncele</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            echo $icerik;
            break;
    }
} catch (PDOException $e) {
    error_log("Veritabanı hatası: " . $e->getMessage());
    echo 'Veritabanı bağlantısı sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
} catch (Exception $e) {
    error_log("Genel hata: " . $e->getMessage());
    echo 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
}

require_once 'views/footer.php';

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderContainer = document.querySelector('.slider-container');
        const slides = document.querySelectorAll('.slide img');
        const slider = document.querySelector('.slider');
        const prevButton = document.querySelector('.prev-slide');
        const nextButton = document.querySelector('.next-slide');

        let slideIndex = 0;

        function setSliderHeight() {
            let maxHeight = 0;
            slides.forEach(slide => {
                if (slide.naturalHeight > maxHeight) {
                    maxHeight = slide.naturalHeight;
                }
            });
            sliderContainer.style.height = `${maxHeight}px`;
        }

        function showSlide(index) {
            slider.style.transform = `translateX(-${index * 33.33}%)`;
        }

        function nextSlide() {
            slideIndex = (slideIndex + 1) % slides.length;
            showSlide(slideIndex);
        }

        function prevSlide() {
            slideIndex = (slideIndex - 1 + slides.length) % slides.length;
            showSlide(slideIndex);
        }

        window.addEventListener('load', setSliderHeight);
        window.addEventListener('resize', setSliderHeight);

        nextButton.addEventListener('click', nextSlide);
        prevButton.addEventListener('click', prevSlide);
    });
</script>