/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-11 18:59:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cardcats
-- ----------------------------
DROP TABLE IF EXISTS `cardcats`;
CREATE TABLE `cardcats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `cardcat_type` varchar(50) DEFAULT NULL,
  `cardcat_title` varchar(50) NOT NULL,
  `cardcat_slug` varchar(50) NOT NULL,
  `cardcat_desc` text,
  `cardcat_url` varchar(200) NOT NULL,
  `cardcat_parent` int(10) unsigned DEFAULT NULL,
  `cardcat_count` smallint(5) unsigned DEFAULT NULL,
  `cardcat_status` enum('enable','disable','expire','public','private','protected') NOT NULL DEFAULT 'enable',
  `date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cardcats_users_id` (`user_id`),
  CONSTRAINT `cardcats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
