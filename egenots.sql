-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Ağu 2024, 02:56:33
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `egenots`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `auth`
--

CREATE TABLE `auth` (
  `username` varchar(16) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(32) NOT NULL,
  `dogum` date NOT NULL,
  `adres` varchar(64) NOT NULL,
  `telno` varchar(16) NOT NULL,
  `yoneticimi` tinyint(1) NOT NULL DEFAULT 0,
  `ip` varchar(20) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `auth`
--

INSERT INTO `auth` (`username`, `password`, `email`, `dogum`, `adres`, `telno`, `yoneticimi`, `ip`, `active`) VALUES
('deneme2', '$2y$10$ongfpOOiZgZaw0rcCEaDceGkkJAXPZgMoxIAo74n7pmOAZhzVHN8O', 'asfasfsad@asdas.com', '0000-00-00', '', '', 0, NULL, 1),
('denemehesabi', '$2y$10$ysgZWr3WfAyzaGGttluyn./YHy.N5XBFhYECNECxygvq/lr9TsUaW', '', '0000-00-00', '', '', 0, NULL, 1),
('ege', '$2y$10$jbinMlW0dzwD6tQ4wqsUbulpYEsvtZPJv8jgZ9dRjOYbmqSvs1VV6', 'ege@ege.com', '0000-00-00', '', '', 0, NULL, 1),
('ege1', '1234', 'ege@example.com', '2000-01-01', 'Some Address', '1234567890', 0, NULL, 1),
('egeege', '$2y$10$TuxlOq40WPJbUR1OwIiUTuyFwCp5tJVBdiMH9wQ6B6Yrj2GscUBbu', '123213@gmail.com', '2112-11-12', 'asdasdfas', '1231231231231232', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `banned`
--

CREATE TABLE `banned` (
  `ip` varchar(20) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `banned`
--

INSERT INTO `banned` (`ip`, `id`) VALUES
('88.230.231.2', 20);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `destek`
--

CREATE TABLE `destek` (
  `username` varchar(32) NOT NULL,
  `tarih` date NOT NULL DEFAULT current_timestamp(),
  `destek` text NOT NULL,
  `cozuldumu` tinyint(1) NOT NULL DEFAULT 0,
  `aciliyet` tinyint(1) NOT NULL DEFAULT 1,
  `baslik` varchar(32) NOT NULL,
  `cevap` text DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `destek`
--

INSERT INTO `destek` (`username`, `tarih`, `destek`, `cozuldumu`, `aciliyet`, `baslik`, `cevap`, `id`) VALUES
('denemehesabi', '2024-08-06', 'asdsafa', 0, 2, 'baslik', '', 1),
('denemehesabi', '2024-08-06', 'deneme açıklama', 1, 1, 'başlık', '', 2),
('denemehesabi', '2024-08-06', 'asdasfda', 1, 2, 'afasdf', '', 3),
('egeege', '2024-08-07', 'Denem2', 1, 3, 'Deneme', '', 4),
('egeege', '2024-08-08', 'asdsa', 1, 1, 'asdsa', 'asdsa', 5),
('egeege', '2024-08-08', 'asdasdfas', 1, 3, 'asddf', '', 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ip`
--

CREATE TABLE `ip` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `zaman` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ip`
--

INSERT INTO `ip` (`id`, `ip`, `zaman`) VALUES
(5, '88.230.231.3', '2024-08-13 14:59:59'),
(6, '88.230.231.2', '2024-08-13 15:12:15'),
(7, '::1', '2024-08-13 20:41:51');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `note` longtext NOT NULL,
  `olusturulma` timestamp NOT NULL DEFAULT current_timestamp(),
  `guncelleme` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `notes`
--

INSERT INTO `notes` (`id`, `username`, `note`, `olusturulma`, `guncelleme`) VALUES
(29, 'denemehesabi', 'asd12sada123sdsa123', '2024-08-06 02:52:58', '2024-08-09 22:37:06'),
(30, 'denemehesabi', 'asdfasdfasdf', '2024-08-06 03:03:44', '2024-08-06 03:03:44'),
(35, 'egeege', '111fvdsafaaa', '2024-08-09 19:22:02', '2024-08-12 22:47:48'),
(36, 'egeege', '1211asfasrfsaf', '2024-08-10 00:27:01', '2024-08-12 22:47:59');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Tablo için indeksler `banned`
--
ALTER TABLE `banned`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Tablo için indeksler `destek`
--
ALTER TABLE `destek`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ip`
--
ALTER TABLE `ip`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `banned`
--
ALTER TABLE `banned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `destek`
--
ALTER TABLE `destek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `ip`
--
ALTER TABLE `ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

DELIMITER $$
--
-- Olaylar
--
CREATE DEFINER=`root`@`localhost` EVENT `temizle_ip` ON SCHEDULE EVERY 1 HOUR STARTS '2024-08-13 02:44:29' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM ip
  WHERE zaman < NOW() - INTERVAL 1 HOUR$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
