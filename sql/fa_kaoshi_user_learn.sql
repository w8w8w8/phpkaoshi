/*
Navicat MySQL Data Transfer

Source Server         : kaoshidb
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tengyudb

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-11-13 15:14:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fa_kaoshi_user_learn
-- ----------------------------
DROP TABLE IF EXISTS `fa_kaoshi_user_learn`;
CREATE TABLE `fa_kaoshi_user_learn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用ID',
  `course_id` int(11) DEFAULT NULL COMMENT '课程ID',
  `learn_time` bigint(20) DEFAULT NULL COMMENT '本次学习时常',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
