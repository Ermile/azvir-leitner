/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : azvir

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-11 18:57:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for papers
-- ----------------------------
DROP TABLE IF EXISTS `papers`;
CREATE TABLE `papers` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `paper_text` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
