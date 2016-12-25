/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : tpshop

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2016-12-25 20:34:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_online`
-- ----------------------------
DROP TABLE IF EXISTS `tp_online`;
CREATE TABLE `tp_online` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `onlinename` varchar(60) NOT NULL COMMENT '客服名称',
  `qq` varchar(13) NOT NULL COMMENT 'qq号码',
  `taobao` varchar(150) NOT NULL DEFAULT '' COMMENT '淘宝旺旺',
  `weixin` varchar(150) NOT NULL DEFAULT '' COMMENT '微信',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序,数字越小排序越靠前',
  `enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:不启用 1：启用',
  PRIMARY KEY (`id`),
  KEY `enable` (`enable`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='在线客服表';

-- ----------------------------
-- Records of tp_online
-- ----------------------------
INSERT INTO `tp_online` VALUES ('2', '小意', '845272922', 'gt_zhong', 'gt845272922', '10', '1');
INSERT INTO `tp_online` VALUES ('3', '小通', '472941765', 'gt_zhong', 'gt472941765', '10', '0');
