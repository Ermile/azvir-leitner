/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-11 18:59:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cardusages
-- ----------------------------
DROP TABLE IF EXISTS `cardusages`;
CREATE TABLE `cardusages` (
  `card_id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `cardcat_id` int(10) unsigned DEFAULT NULL,
  `cardusage_deck` smallint(5) unsigned DEFAULT NULL,
  `cardusage_try` smallint(5) unsigned DEFAULT NULL,
  `cardusage_trysuccess` smallint(5) unsigned DEFAULT NULL,
  `cardusage_expire` datetime DEFAULT NULL,
  `cardusage_lasttry` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY `cardusages_users_id` (`user_id`),
  KEY `cardusages_cards_id` (`card_id`),
  KEY `cardusages_cardcats_id` (`cardcat_id`),
  CONSTRAINT `cardusages_ibfk_1` FOREIGN KEY (`cardcat_id`) REFERENCES `cardcats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cardusages_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cardusages_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
