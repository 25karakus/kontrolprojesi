/*
 Navicat Premium Dump SQL

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : verison3

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 04/04/2025 21:07:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for destek_talebi_yanitlari
-- ----------------------------
DROP TABLE IF EXISTS `destek_talebi_yanitlari`;
CREATE TABLE `destek_talebi_yanitlari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `talep_id` int NOT NULL,
  `kullanici_id` int NOT NULL,
  `yanit` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `talep_id`(`talep_id` ASC) USING BTREE,
  INDEX `kullanici_id`(`kullanici_id` ASC) USING BTREE,
  CONSTRAINT `destek_talebi_yanitlari_ibfk_1` FOREIGN KEY (`talep_id`) REFERENCES `destek_talepleri` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `destek_talebi_yanitlari_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of destek_talebi_yanitlari
-- ----------------------------
INSERT INTO `destek_talebi_yanitlari` VALUES (1, 7, 2, 'denemne', '2025-03-29 15:52:28');
INSERT INTO `destek_talebi_yanitlari` VALUES (2, 7, 2, 'deneme hayır', '2025-03-29 15:59:09');

-- ----------------------------
-- Table structure for destek_talebi_yorumları
-- ----------------------------
DROP TABLE IF EXISTS `destek_talebi_yorumları`;
CREATE TABLE `destek_talebi_yorumları`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `talep_id` int NOT NULL,
  `kullanici_id` int NOT NULL,
  `yorum` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tarih` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `talep_id`(`talep_id` ASC) USING BTREE,
  INDEX `kullanici_id`(`kullanici_id` ASC) USING BTREE,
  CONSTRAINT `destek_talebi_yorumları_ibfk_1` FOREIGN KEY (`talep_id`) REFERENCES `destek_talepleri` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `destek_talebi_yorumları_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of destek_talebi_yorumları
-- ----------------------------

-- ----------------------------
-- Table structure for destek_talepleri
-- ----------------------------
DROP TABLE IF EXISTS `destek_talepleri`;
CREATE TABLE `destek_talepleri`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_id` int NOT NULL,
  `baslik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `aciklama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `durum` enum('Açık','İşleniyor','Kapalı') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Açık',
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `guncelleme_tarihi` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE CURRENT_TIMESTAMP,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `oncelik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosya_yol` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kullanici_id`(`kullanici_id` ASC) USING BTREE,
  CONSTRAINT `destek_talepleri_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of destek_talepleri
-- ----------------------------
INSERT INTO `destek_talepleri` VALUES (7, 2, 'deneme başlık', 'deneme amaçlı yapıldı', 'Açık', '2025-03-28 00:02:41', '2025-03-28 00:02:41', '', '', NULL);
INSERT INTO `destek_talepleri` VALUES (8, 2, 'ewq', 'alan-adi', 'Açık', '2025-03-28 00:35:54', '2025-03-28 00:35:54', '', '', NULL);
INSERT INTO `destek_talepleri` VALUES (9, 2, 'w', 'w', 'Açık', '2025-03-28 00:56:35', '2025-03-28 00:56:35', '', '', NULL);
INSERT INTO `destek_talepleri` VALUES (10, 2, 'denem 2', 'ewqeqw', 'Açık', '2025-03-29 04:14:10', '2025-03-29 04:14:10', '', '', NULL);
INSERT INTO `destek_talepleri` VALUES (11, 2, 'denem ebaslık şifrr', 'ewqe', 'Açık', '2025-04-03 20:34:52', '2025-04-03 20:34:52', '', '', NULL);

-- ----------------------------
-- Table structure for domains
-- ----------------------------
DROP TABLE IF EXISTS `domains`;
CREATE TABLE `domains`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `domain_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` date NULL DEFAULT NULL,
  `expiration_date` date NULL DEFAULT NULL,
  `user_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `domain_name`(`domain_name` ASC) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `domains_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of domains
-- ----------------------------

-- ----------------------------
-- Table structure for eposta_ayarlari
-- ----------------------------
DROP TABLE IF EXISTS `eposta_ayarlari`;
CREATE TABLE `eposta_ayarlari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `smtp_sunucu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_kullanici_adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_sifre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `smtp_port` int NOT NULL,
  `smtp_guvenlik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gonderen_eposta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gonderen_ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eposta_ayarlari
-- ----------------------------
INSERT INTO `eposta_ayarlari` VALUES (1, 'smtp.gmail.com', 'teknikyazilimci@gmail.com', 'rult ltox duzp vbqj', 587, 'tls', 'teknikyazilimci@gmail.com', 'Teknik Yazılımcı');

-- ----------------------------
-- Table structure for faturalar
-- ----------------------------
DROP TABLE IF EXISTS `faturalar`;
CREATE TABLE `faturalar`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `musteri_id` int NULL DEFAULT NULL,
  `hizmet_id` int NULL DEFAULT NULL,
  `tutar` decimal(10, 2) NULL DEFAULT NULL,
  `odeme_tarihi` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `musteri_id`(`musteri_id` ASC) USING BTREE,
  INDEX `hizmet_id`(`hizmet_id` ASC) USING BTREE,
  CONSTRAINT `faturalar_ibfk_1` FOREIGN KEY (`musteri_id`) REFERENCES `musteriler` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `faturalar_ibfk_2` FOREIGN KEY (`hizmet_id`) REFERENCES `hizmetler` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of faturalar
-- ----------------------------

-- ----------------------------
-- Table structure for hizmetler
-- ----------------------------
DROP TABLE IF EXISTS `hizmetler`;
CREATE TABLE `hizmetler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `musteri_id` int NULL DEFAULT NULL,
  `hizmet_adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `baslangic_tarihi` date NULL DEFAULT NULL,
  `bitis_tarihi` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `musteri_id`(`musteri_id` ASC) USING BTREE,
  CONSTRAINT `hizmetler_ibfk_1` FOREIGN KEY (`musteri_id`) REFERENCES `musteriler` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hizmetler
-- ----------------------------

-- ----------------------------
-- Table structure for hosting_packages
-- ----------------------------
DROP TABLE IF EXISTS `hosting_packages`;
CREATE TABLE `hosting_packages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `disk_space` int NULL DEFAULT NULL,
  `bandwidth` int NULL DEFAULT NULL,
  `price` decimal(10, 2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hosting_packages
-- ----------------------------

-- ----------------------------
-- Table structure for kullanicilar
-- ----------------------------
DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE `kullanicilar`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `soyad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sifre_sifirlama_anahtari` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sifre_sifirlama_anahtari_son_kullanma` datetime NULL DEFAULT NULL,
  `telefon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE,
  UNIQUE INDEX `email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kullanicilar
-- ----------------------------
INSERT INTO `kullanicilar` VALUES (1, 'dadas', '1', '', '2025-03-25 22:39:10', 'dsad', 'dsadsa', NULL, NULL, '');
INSERT INTO `kullanicilar` VALUES (2, 'kral', '$2y$10$/ffXUV3UQkrPAzpUmOxB2.50KCakrzw5TqFM4OhpmTlVgLskauOfq', 'firatkarakus@outlook.com', '2025-03-26 00:04:19', 'ssss', 'sss', NULL, NULL, '');
INSERT INTO `kullanicilar` VALUES (4, 'dadasb', '1', 'ovakit@hotmail.com', '2025-03-26 01:25:34', NULL, NULL, NULL, NULL, '');
INSERT INTO `kullanicilar` VALUES (5, 'dadakralwq', '$2y$10$9g3QPQjAXd9MIna8h9Foe.3DmJE4vnR2tUhR43SaIwr2g64N.ul8i', 'firat25lara@hotmail.com', '2025-03-26 23:43:37', NULL, NULL, NULL, NULL, '');

-- ----------------------------
-- Table structure for musteriler
-- ----------------------------
DROP TABLE IF EXISTS `musteriler`;
CREATE TABLE `musteriler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_id` int NULL DEFAULT NULL,
  `ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `soyad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telefon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kullanici_id`(`kullanici_id` ASC) USING BTREE,
  CONSTRAINT `musteriler_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of musteriler
-- ----------------------------

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `service_id` int NULL DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `service_id`(`service_id` ASC) USING BTREE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for sepet
-- ----------------------------
DROP TABLE IF EXISTS `sepet`;
CREATE TABLE `sepet`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `musteri_id` int NULL DEFAULT NULL,
  `urun_id` int NULL DEFAULT NULL,
  `adet` int NULL DEFAULT NULL,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `musteri_id`(`musteri_id` ASC) USING BTREE,
  INDEX `urun_id`(`urun_id` ASC) USING BTREE,
  CONSTRAINT `sepet_ibfk_1` FOREIGN KEY (`musteri_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sepet_ibfk_2` FOREIGN KEY (`urun_id`) REFERENCES `urunler` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sepet
-- ----------------------------

-- ----------------------------
-- Table structure for sepet_verileri
-- ----------------------------
DROP TABLE IF EXISTS `sepet_verileri`;
CREATE TABLE `sepet_verileri`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_id` int NOT NULL,
  `urun_id` int NOT NULL,
  `adet` int NOT NULL,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `kullanici_id`(`kullanici_id` ASC) USING BTREE,
  INDEX `urun_id`(`urun_id` ASC) USING BTREE,
  CONSTRAINT `sepet_verileri_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sepet_verileri_ibfk_2` FOREIGN KEY (`urun_id`) REFERENCES `urunler` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sepet_verileri
-- ----------------------------

-- ----------------------------
-- Table structure for services
-- ----------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `user_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  CONSTRAINT `services_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of services
-- ----------------------------

-- ----------------------------
-- Table structure for urunler
-- ----------------------------
DROP TABLE IF EXISTS `urunler`;
CREATE TABLE `urunler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `aciklama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `fiyat` decimal(10, 2) NOT NULL,
  `tur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of urunler
-- ----------------------------

-- ----------------------------
-- Table structure for user_hosting_packages
-- ----------------------------
DROP TABLE IF EXISTS `user_hosting_packages`;
CREATE TABLE `user_hosting_packages`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `package_id` int NULL DEFAULT NULL,
  `start_date` date NULL DEFAULT NULL,
  `end_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `package_id`(`package_id` ASC) USING BTREE,
  CONSTRAINT `user_hosting_packages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `kullanicilar` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_hosting_packages_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `hosting_packages` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_hosting_packages
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
