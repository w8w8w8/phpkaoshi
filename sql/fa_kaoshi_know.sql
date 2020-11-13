/*
Navicat MySQL Data Transfer

Source Server         : kaoshidb
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tengyudb

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-11-13 17:24:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fa_kaoshi_know
-- ----------------------------
DROP TABLE IF EXISTS `fa_kaoshi_know`;
CREATE TABLE `fa_kaoshi_know` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knowid` varchar(11) DEFAULT NULL,
  `knowtitle` varchar(255) DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `knowdesc` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
