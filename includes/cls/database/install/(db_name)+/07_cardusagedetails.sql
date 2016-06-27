/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-26 18:08:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cardusagedetails
-- ----------------------------
DROP TABLE IF EXISTS `cardusagedetails`;
CREATE TABLE `cardusagedetails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cardusage_id` int(10) unsigned NOT NULL,
  `cardusagedetail_answer` enum('true','false','skip','') CHARACTER SET utf8 NOT NULL,
  `cardusagedetail_spendtime` int(11) unsigned DEFAULT NULL,
  `cardusagedetail_deck` smallint(5) unsigned DEFAULT NULL,
  `cardusagedetail_datetime` datetime DEFAULT NULL,
  `cardusagedetail_meta` mediumtext,
  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cardusagedetails_ibfk_1` (`cardusage_id`),
  CONSTRAINT `cardusagedetails_ibfk_1` FOREIGN KEY (`cardusage_id`) REFERENCES `cardusages` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cardusagedetails
-- ----------------------------
