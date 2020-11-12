/*
Navicat MySQL Data Transfer

Source Server         : kaoshidb
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tengyudb

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-11-12 15:45:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for fa_kaoshi_user_question
-- ----------------------------
DROP TABLE IF EXISTS `fa_kaoshi_user_question`;
CREATE TABLE `fa_kaoshi_user_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) DEFAULT NULL COMMENT '试卷ID',
  `plan_id` int(11) DEFAULT NULL COMMENT '计划ID',
  `question_id` int(11) DEFAULT NULL COMMENT '试题ID',
  `user_answer` varchar(255) DEFAULT NULL COMMENT '用户答案，采用逗号分隔，并大写',
  `user_score` int(11) DEFAULT '0' COMMENT '本题得分',
  `user_result` int(11) DEFAULT NULL COMMENT '本题是否回答正确 0不正确，1正确',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
