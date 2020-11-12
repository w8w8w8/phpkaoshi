/*
Navicat MySQL Data Transfer

Source Server         : kaoshidb
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tengyudb

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-11-12 15:45:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fa_kaoshi_user_know
-- ----------------------------
DROP TABLE IF EXISTS `fa_kaoshi_user_know`;
CREATE TABLE `fa_kaoshi_user_know` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `know_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
