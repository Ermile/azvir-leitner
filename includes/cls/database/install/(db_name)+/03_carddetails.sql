/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-11 18:59:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for carddetails
-- ----------------------------
DROP TABLE IF EXISTS `carddetails`;
CREATE TABLE `carddetails` (
  `user_id` int(10) unsigned NOT NULL,
  `card_id` bigint(20) unsigned NOT NULL,
  `carddetail_date` datetime NOT NULL,
  `carddetail_status` enum('success','fail','ignore','change') NOT NULL,
  KEY `carddetails_users_id` (`user_id`),
  KEY `carddetails_cards_id` (`card_id`),
  CONSTRAINT `carddetails_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `carddetails_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
