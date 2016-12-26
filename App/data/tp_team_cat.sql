/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : tpshop

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2016-12-26 22:33:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_team_cat`
-- ----------------------------
DROP TABLE IF EXISTS `tp_team_cat`;
CREATE TABLE `tp_team_cat` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `cat_name` varchar(60) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='团队分类表';

-- ----------------------------
-- Records of tp_team_cat
-- ----------------------------
INSERT INTO `tp_team_cat` VALUES ('1', '设计团队');
INSERT INTO `tp_team_cat` VALUES ('2', '管理团队');
INSERT INTO `tp_team_cat` VALUES ('3', 'IT团队');
INSERT INTO `tp_team_cat` VALUES ('4', '售后团队');
