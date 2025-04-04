<?php

require_once 'models/MusteriModel.php';
require_once 'models/HizmetModel.php';
require_once 'models/FaturaModel.php';
require_once 'models/DestekTalepModel.php';

class MusteriPanelController {
    private $musteriModel;
    private $hizmetModel;
    private $faturaModel;
    private $destekTalepModel;

    public function __construct($db) {
        $this->musteriModel = new MusteriModel($db);
        $this->hizmetModel = new HizmetModel($db);
        $this->faturaModel = new FaturaModel($db);
        $this->destekTalepModel = new DestekTalepModel($db);
    }

    public function anasayfa() {
        require_once 'views/musteri-paneli/anasayfa.php';
    }

    public function hizmetler() {
        require_once 'views/musteri-paneli/hizmetler.php';
    }

    public function faturalar() {
        require_once 'views/musteri-paneli/faturalar.php';
    }

    public function destekTalepleri() {
        require_once 'views/musteri-paneli/destek-talepleri.php';
    }

    public function yeniDestekTalebiFormu() {
        require_once 'views/musteri-paneli/yeni-destek-talebi.php';
    }

    public function yeniDestekTalebiKaydet() {
        $musteri_id = $this->musteriModel->getMusteriIdByKullaniciId($_SESSION['user_id']);
        $baslik = $_POST['baslik'];
        $aciklama = $_POST['aciklama'];

        $this->destekTalepModel->yeniDestekTalebi($musteri_id, $baslik, $aciklama);

        header('Location: index.php?action=musteri-destek');
    }

    // ... diğer metotlar ...
}

?>