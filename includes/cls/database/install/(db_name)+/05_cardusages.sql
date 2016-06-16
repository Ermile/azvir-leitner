/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-16 19:41:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cardusages
-- ----------------------------
DROP TABLE IF EXISTS `cardusages`;
CREATE TABLE `cardusages` (
  `cardlist_id` int(11) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `cardusage_deck` smallint(5) unsigned DEFAULT NULL,
  `cardusage_try` smallint(5) unsigned DEFAULT NULL,
  `cardusage_trysuccess` smallint(5) unsigned DEFAULT NULL,
  `cardusage_expire` datetime DEFAULT NULL,
  `cardusage_lasttry` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  KEY `cardusages_users_id` (`user_id`),
  KEY `cardusages_ibfk_4` (`cardlist_id`),
  CONSTRAINT `cardusages_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cardusages_ibfk_4` FOREIGN KEY (`cardlist_id`) REFERENCES `cardlists` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cardusages
-- ----------------------------
