/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : tpshop

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2016-12-26 22:33:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_team`
-- ----------------------------
DROP TABLE IF EXISTS `tp_team`;
CREATE TABLE `tp_team` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `username` varchar(60) NOT NULL COMMENT '员工姓名',
  `content` text NOT NULL COMMENT '内容',
  `original` varchar(150) NOT NULL DEFAULT '' COMMENT '原图',
  `thumb1` varchar(150) NOT NULL DEFAULT '' COMMENT '后台列表缩略图50*50',
  `thumb2` varchar(150) NOT NULL DEFAULT '' COMMENT '后台内容缩略图100*100',
  `thumb3` varchar(150) NOT NULL DEFAULT '' COMMENT '列表页缩略图140*140',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '团队分类表',
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1在职0离职',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `tp_team_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `tp_team_cat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='团队表';

-- ----------------------------
-- Records of tp_team
-- ----------------------------
INSERT INTO `tp_team` VALUES ('1', '李利明', '&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;	&lt;span style=&quot;font-size:16px;&quot;&gt;&lt;strong&gt;社会职务：&lt;img src=&quot;http://www.shangtai.com/0.5/Public/ueditor/php/upload/79731425992211.jpg&quot; alt=&quot;&quot; align=&quot;right&quot; height=&quot;266&quot; width=&quot;150&quot;/&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;广东省装饰行业协会会员&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;深圳市装饰行业协会会员&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;SIAID深圳室内设计师协会会员&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;尚泰风设计委员会委员&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;	&lt;span style=&quot;font-size:16px;&quot;&gt;&lt;strong&gt;毕业院校：&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;武汉纺织大学&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;	&lt;span style=&quot;font-size:16px;&quot;&gt;&lt;strong&gt;所获荣誉：&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2010年深圳“高级室内设计师”职称&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;	&lt;span style=&quot;font-size:16px;&quot;&gt;&lt;strong&gt;个人特长：&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;致力于展厅、写字楼及时尚饮食业的室内设计&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;	&lt;span style=&quot;font-size:16px;&quot;&gt;&lt;strong&gt;主要业绩：&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;星河第三空间家纺店、松日鼎盛办公室、长平商务大厦办公室、锦丰贝尔漫商务酒店&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;	&lt;span style=&quot;font-size:16px;&quot;&gt;&lt;strong&gt;设计格言：&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp; &amp;nbsp;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;无论设计的东西再华丽、再新颖、再颠覆都是给人用的。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', 'Uploads/Team/Original/20150310/54feea7b7c16c.jpg', 'Uploads/Team/Thumb/50-50/20150310/54feea7b7c16c.jpg', 'Uploads/Team/Thumb/100-100/20150310/54feea7b7c16c.jpg', 'Uploads/Team/Thumb/140-140/20150310/54feea7b7c16c.jpg', '1', '0');
INSERT INTO `tp_team` VALUES ('2', '詹华', '&lt;p&gt;\r\n	&lt;strong&gt;社会职务：&lt;/strong&gt;&lt;img alt=&quot;&quot; src=&quot;http://www.shangtai.com/0.5/Public/ueditor/php/upload/29901425993053.jpg&quot; align=&quot;right&quot; height=&quot;270&quot; width=&quot;160&quot;/&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 中国室内建筑设计师协会高级室内建筑设计师 &amp;nbsp; &amp;nbsp;&lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; 广东省装饰行业协会会员&lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; SZAID深圳市装饰行业协会会员&lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 尚泰装饰设计总监&lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;毕业学校：&lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;湖南中南林学院&lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;个人特长： &lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;展厅、专卖店、办公室、餐饮酒楼、别墅豪宅设计&lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;获得荣誉：&lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2010年 &amp;nbsp; &amp;nbsp;海峡两岸四地室内设计大赛办公室类优秀奖&lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2009年 &amp;nbsp; &amp;nbsp;搜狐室内设计优秀奖&lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2008年 “中国照明应用设计大赛”优秀奖&lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;2007年 “金外滩”室内设计入围奖&lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;主要业绩：&lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;工装部分：&lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; \r\n&amp;nbsp;南海意库-欧比特贸易公司办公室项目、美年广场-辉创科技公司办公室项目、海岸大厦-天盛能源办公室项目、南海意库-杰弗瑞景观设计办公室项目、海岸城\r\n东座2楼办公室项目、海岸城西座16楼办公室项目、东莞服装城项目、燠斯伦华侨酒吧设计项目、华南城办公室项目、皇岗商务大厦19层办公室项目&lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;家装部分：&lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 天鹅堡别墅、招商海月、龙园意境、宝能太古城、国际公馆、帝景园、西海明珠、岚峰苑、南国丽城、城市山林三期、信和自由广场、金海岸大厦、南海玫瑰园、花园城、招商海琴花园、鸿瑞花园、海月花园、锦锈花园、世界花园、中旅广场等。&lt;/p&gt;&lt;p&gt;\r\n	&lt;strong&gt;设计格言：&lt;/strong&gt; &lt;/p&gt;&lt;p&gt;\r\n	&amp;nbsp; &amp;nbsp;气脉相连，人宅相扶。&lt;/p&gt;', '/assets/admin/team/02023100-0004/original/02023100-0004_2.jpg', '/assets/admin/team/02023100-0004/thumb/100x/02023100-0004_2.jpg', '/assets/admin/team/02023100-0004/thumb/300x/02023100-0004_2.jpg', '/assets/admin/team/02023100-0004/thumb/600x/02023100-0004_2.jpg', '2', '1');
