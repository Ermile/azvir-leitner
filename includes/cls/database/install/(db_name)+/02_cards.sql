/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-11 18:57:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cards
-- ----------------------------
DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `card_front` int(10) unsigned NOT NULL,
  `card_back` int(10) unsigned NOT NULL,
  `card_createdate` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cards_ibfk_1` (`card_back`),
  KEY `cards_ibfk_2` (`card_front`),
  CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`card_back`) REFERENCES `papers` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `cards_ibfk_2` FOREIGN KEY (`card_front`) REFERENCES `papers` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
