/*
Navicat MySQL Data Transfer

Source Server         : php2
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : tpshop

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2017-02-05 13:22:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_payment`
-- ----------------------------
DROP TABLE IF EXISTS `tp_payment`;
CREATE TABLE `tp_payment` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(20) NOT NULL DEFAULT '' COMMENT '支付方式英文类名',
  `pay_name` varchar(120) NOT NULL DEFAULT '' COMMENT '支付方式中文名称',
  `pay_fee` varchar(10) NOT NULL DEFAULT '0' COMMENT '手续费',
  `pay_desc` text NOT NULL COMMENT '支付的描述',
  `pay_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pay_config` text NOT NULL COMMENT '序列化的配置信息',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启，1开启。0关闭',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_payment
-- ----------------------------
INSERT INTO `tp_payment` VALUES ('1', 'wechatpay', '微信', '0', '微信支付，简单快捷', '1', 'a:3:{s:7:\"account\";s:17:\"alifsfdsf@163.com\";s:3:\"key\";s:18:\"47848fdsafsaff4545\";s:7:\"partner\";s:18:\"47848fdsafsaff4545\";}', '1');
INSERT INTO `tp_payment` VALUES ('2', 'alipay', '支付宝', '0', '支付宝担保交易，保障安全', '2', 'a:4:{s:7:\"account\";s:15:\"gtzhong@126.com\";s:3:\"key\";s:6:\"hahahh\";s:7:\"partner\";s:6:\"456454\";s:17:\"alipay_pay_method\";s:1:\"1\";}', '1');
