-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 17. Apr 2020 um 18:13
-- Server-Version: 5.7.28
-- PHP-Version: 7.4.1
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Datenbank: `stink_db`
--
CREATE DATABASE IF NOT EXISTS `stink_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_german1_ci;
USE `stink_db`;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `locations`
--
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coordinates` point NOT NULL,
  `street` mediumtext COLLATE latin1_german1_ci,
  `number` tinytext COLLATE latin1_german1_ci,
  `zip` tinytext COLLATE latin1_german1_ci,
  `city` tinytext COLLATE latin1_german1_ci,
  `country` tinytext COLLATE latin1_german1_ci,
  PRIMARY KEY (`id`),
  KEY `coordinates` (`coordinates`(25))
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german1_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `reports`
--
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL,
  `stink_kind_id` int(10) UNSIGNED NOT NULL,
  `intensity` tinyint(3) UNSIGNED NOT NULL,
  `temperature` DECIMAL(5, 2) NOT NULL,
  `wind_direction` DECIMAL(5, 2) NOT NULL,
  `wind_speed` DECIMAL(5, 2) NOT NULL,
  `wind_gust_speed` DECIMAL(5, 2),
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `location_id` (`location_id`),
  KEY `stink_kind_id` (`stink_kind_id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german1_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `stink_kinds`
--
CREATE TABLE IF NOT EXISTS `stink_kinds` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german1_ci;
--
-- Constraints der exportierten Tabellen
--
--
-- Constraints der Tabelle `reports`
--
ALTER TABLE `reports`
ADD CONSTRAINT `fk_reports_location` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `fk_reports_stink_kind` FOREIGN KEY (`stink_kind_id`) REFERENCES `stink_kinds` (`id`);
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;

DELIMITER $$
CREATE PROCEDURE InsertReport(
  IN report_time datetime,
  IN stink_kind text,
  IN intensity tinyint,
  IN insert_coordinates point,
  IN street mediumtext,
  IN street_number tinytext,
  IN zip tinytext,
  IN city tinytext,
  IN country tinytext,
  IN temperature decimal,
  IN wind_direction decimal,
  IN wind_speed decimal,
  IN wind_gust_speed decimal
) BEGIN
DECLARE matching_stink_count int DEFAULT 0;
DECLARE stink_id int DEFAULT 0;
DECLARE matching_coordinates_count int DEFAULT 0;
DECLARE location_id int DEFAULT 0;
SELECT COUNT(*) INTO matching_stink_count
FROM stink_kinds
WHERE name = stink_kind;
IF matching_stink_count > 0 THEN
SELECT id INTO stink_id
FROM stink_kinds
WHERE name = stink_kind;
ELSE
INSERT INTO stink_kinds (name)
VALUES (stink_kind);
SELECT LAST_INSERT_ID() INTO stink_id;
END IF;
SELECT COUNT(*) INTO matching_coordinates_count
FROM locations
WHERE coordinates = insert_coordinates;
IF matching_coordinates_count > 0 THEN
SELECT id INTO location_id
FROM locations
WHERE coordinates = insert_coordinates;
ELSE
INSERT INTO locations (coordinates, street, number, zip, city, country)
VALUES (
    insert_coordinates,
    street,
    street_number,
    zip,
    city,
    country
  );
SELECT LAST_INSERT_ID() INTO location_id;
END IF;
INSERT INTO reports (
    location_id,
    stink_kind_id,
    intensity,
    time,
    temperature,
    wind_direction,
    wind_speed,
    wind_gust_speed
  )
VALUES (
    location_id,
    stink_id,
    intensity,
    report_time,
    temperature,
    wind_direction,
    wind_speed,
    wind_gust_speed
  );
END $$
DELIMITER ;