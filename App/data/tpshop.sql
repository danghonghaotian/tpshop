-- 2016-12-2
CREATE TABLE tp_goods
(
	id mediumint unsigned not null auto_increment comment 'id',
	goods_name varchar(30) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价',
	shop_price decimal(10,2) not null comment '本店价',
	goods_sn char(10) not null comment '商品货号',
	cat_id smallint unsigned not null comment '商品分类',
	brand_id smallint unsigned not null default '0' comment '品牌',
	sm_logo varchar(150) not null default '' comment '最小的缩略图：100*100',
	sm1_logo varchar(150) not null default '' comment '300*300',
	sm2_logo varchar(150) not null default '' comment '600*600',
	logo varchar(150) not null default '' comment '原图',
	goods_desc longtext comment '商品描述',
	weight varchar(10) not null default '' comment '重量',
	weight_unit enum("g","kg") not null default "kg" comment '单位',
	is_on_sale tinyint unsigned not null default '1' comment '是否上架',
	no_postage tinyint unsigned not null default '0' comment '是否包邮',
	is_delete tinyint unsigned not null default '0' comment '是否回收站',
	type_id smallint unsigned not null default '0' comment '商品类型',
	primary key (id),
	key shop_price(shop_price),
	key goods_sn(goods_sn),
	key cat_id(cat_id),
	key brand_id(brand_id),
	key is_on_sale(is_on_sale),
	key is_delete(is_delete),
	key type_id(type_id)
)engine=InnoDB default charset=utf8 comment '商品表';

-- 2016-12-6
ALTER TABLE `tp_goods`
ADD COLUMN `goods_number`  smallint(5) UNSIGNED NOT NULL AFTER `goods_name`;
ALTER TABLE `tp_goods`
MODIFY COLUMN `goods_number`  smallint(5) UNSIGNED NOT NULL COMMENT '商品数量' AFTER `goods_name`;

-- 修改商品sku长度
ALTER TABLE `tp_goods`
MODIFY COLUMN `goods_sn`  char(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品货号' AFTER `shop_price`;

-- 商品名称要是英文的时候，好长
ALTER TABLE `tp_goods`
MODIFY COLUMN `goods_name`  varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称' AFTER `id`;




--  2016-12-02
CREATE TABLE tp_goods_gallery
(
	id int unsigned not null auto_increment comment 'id',
	goods_id mediumint unsigned not null comment '商品id',
	sm_logo varchar(150) not null default '' comment '最小的缩略图：100*100',
	sm1_logo varchar(150) not null default '' comment '300*300',
	sm2_logo varchar(150) not null default '' comment '600*600',
	logo varchar(150) not null default '' comment '原图',
	primary key (id),
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品图片表';

-- 删除商品的时候，不删除图片，这样删掉数据表数据就行了 2016-2-10
ALTER TABLE `tp_goods_gallery`
ENGINE=InnoDB;

ALTER TABLE `tp_goods_gallery` ADD CONSTRAINT `tp_goods_gallery_id` FOREIGN KEY (`goods_id`) REFERENCES `tp_goods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;


-- 2016-12-02
CREATE TABLE tp_goods_attr
(
	id int unsigned not null auto_increment comment 'id',
	goods_id mediumint unsigned not null comment '商品id',
	attr_id mediumint unsigned not null comment '属性id',
	attr_value varchar(150) not null default '' comment '属性的值',
	primary key (id),
	foreign key (goods_id) references tp_goods(id) on delete cascade,
	foreign key (attr_id) references tp_attribute(id) on delete cascade
)engine=InnoDB default charset=utf8 comment '商品属性表';

-- 2016-12-6
ALTER TABLE `tp_goods_attr`
ADD COLUMN `attr_price`  decimal(8,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '属性额外价' AFTER `attr_value`;


-- 2016-12-5
DROP TABLE IF EXISTS tp_member_price;
CREATE TABLE `tp_member_price` (
  `price_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0' comment '商品id',
  `user_rank` smallint(5)  unsigned NOT NULL  comment '会员级别',
  `user_price` decimal(10,2) NOT NULL DEFAULT '0.00' comment '会员价格',
  PRIMARY KEY (`price_id`),
  KEY `goods_id` (`goods_id`),
  KEY `user_rank` (`user_rank`),
  foreign key (goods_id) references tp_goods(id) on delete cascade,
	foreign key (user_rank) references tp_user_rank(id) on delete cascade
) engine=InnoDB default charset=utf8 comment '会员价格表';


-- tp_nav 2016-12-11
ALTER TABLE `ecs_nav`
DROP COLUMN `ctype`,
DROP COLUMN `cid`;
ALTER TABLE `tp_nav`
CHANGE COLUMN `ifshow` `is_show`  tinyint(1) NOT NULL AFTER `name`,
CHANGE COLUMN `vieworder` `view_order`  tinyint(1) NOT NULL AFTER `is_show`,
CHANGE COLUMN `opennew` `open_new`  tinyint(1) NOT NULL AFTER `view_order`;
ALTER TABLE `tp_nav`
MODIFY COLUMN `id`  mediumint(8) NOT NULL AUTO_INCREMENT COMMENT 'id' FIRST ,
MODIFY COLUMN `name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '导航栏名称' AFTER `id`,
MODIFY COLUMN `is_show`  tinyint(1) NOT NULL COMMENT '是否显示' AFTER `name`,
MODIFY COLUMN `view_order`  tinyint(1) NOT NULL COMMENT '排序' AFTER `is_show`,
MODIFY COLUMN `open_new`  tinyint(1) NOT NULL COMMENT '是否新窗口' AFTER `view_order`,
MODIFY COLUMN `url`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '链接' AFTER `open_new`,
MODIFY COLUMN `type`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '位置' AFTER `url`,
DROP INDEX `ifshow` ,
ADD INDEX `is_show` (`is_show`) USING BTREE ;
ALTER TABLE `tp_nav`
CHANGE COLUMN `type` `position`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '位置' AFTER `url`;


CREATE TABLE tp_ad_position
(
	id mediumint unsigned not null auto_increment comment 'id',
	adpos_name varchar(30) not null comment '广告位名称',
	adpos_width smallint unsigned not null comment '广告位的宽',
	adpos_height smallint unsigned not null comment '广告位的高',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '广告位表';

CREATE TABLE `tp_ad` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(30) NOT NULL,
  `ad_img` varchar(255) NOT NULL,
  `adpos_id` mediumint(8) unsigned NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '开始时间',
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `ad_url` varchar(255) NOT NULL,
  `open_new` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启状态0开启1不开启',
  PRIMARY KEY (`id`),
  KEY `adpos_id` (`adpos_id`),
  CONSTRAINT `ad` FOREIGN KEY (`adpos_id`) REFERENCES `tp_ad_position` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `tp_ad`
MODIFY COLUMN `enabled`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '开启状态0开启1不开启' AFTER `open_new`;
ALTER TABLE `tp_ad`
ADD COLUMN `sm1_logo`  varchar(255) NOT NULL COMMENT '广告等比例缩小图' AFTER `ad_img`,
ADD COLUMN `sm2_logo`  varchar(255) NOT NULL COMMENT '真正的广告图' AFTER `sm1_logo`;

-- 首页商品推荐表
CREATE TABLE `tp_goods_recommendation` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` tinyint(3) unsigned NOT NULL,
  `goods_sn` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-12-25
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='在线客服表';


ALTER TABLE `tp_user`
ADD COLUMN `active`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未激活，1激活' AFTER `reg_time`;

-- 2017-1-15
CREATE TABLE `tp_product` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品',
  `goods_number` int(10) unsigned NOT NULL COMMENT '库存量',
  `goodsattr_id` varchar(30) NOT NULL COMMENT '属性的ID，如果有多个属性，那么先根据ID升序排序然后再用，号隔开,关联的是sh_goods_attr表的ID',
  PRIMARY KEY (`goods_id`,`goodsattr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `goodsattr_id` (`goodsattr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='货品表';

ALTER TABLE `tp_user`
ENGINE=InnoDB;

CREATE TABLE `tp_cart` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '会员的ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品的ID',
  `goods_number` int(10) unsigned NOT NULL COMMENT '商品的数量',
  `goods_attr` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性的ID',
  PRIMARY KEY (`id`),
  KEY `cat_user` (`user_id`),
  CONSTRAINT `cat_user` FOREIGN KEY (`user_id`) REFERENCES `tp_user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';

-- 这id是多余的，删掉
ALTER TABLE `tp_cart`
DROP COLUMN `id`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`user_id`, `goods_id`, `goods_attr`);

-- 属性字符串连接方法
SELECT GROUP_CONCAT(CONCAT(b.attr_name,':',a.attr_value) SEPARATOR '
') goodsAttrStr FROM tp_goods_attr a LEFT JOIN tp_attribute b ON a.attr_id=b.id WHERE a.id IN(181,183);

-- 2017-2-4
CREATE TABLE tp_address
(
	id mediumint unsigned not null auto_increment comment 'id',
	user_id mediumint(8) unsigned not null comment '会员的ID',
	consignee varchar(30) not null comment '收货人姓名',
	province smallint(5) unsigned not null comment '省',
	city smallint(5) unsigned not null comment '市',
	area smallint(5) unsigned not null comment '地区',
	address varchar(150) not null comment '详细地址',
	tel varchar(20) not null comment '收货人电话',
	is_default tinyint unsigned not null default '1' comment '是否默认的地址',
	primary key (id),
	foreign key (user_id) references tp_user(user_id) on delete cascade
)engine=InnoDB default charset=utf8 comment '用户收货地址表';

-- 2017-2-5
CREATE TABLE `tp_payment` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pay_code` varchar(20) NOT NULL DEFAULT ''  comment '支付方式英文类名',
  `pay_name` varchar(120) NOT NULL DEFAULT ''  comment '支付方式中文名称',
  `pay_fee` varchar(10) NOT NULL DEFAULT '0'  comment '手续费',
  `pay_desc` text NOT NULL  comment '支付的描述',
  `pay_order` tinyint(3) unsigned NOT NULL DEFAULT '0'  comment '排序',
  `pay_config` text NOT NULL  comment '序列化的配置信息',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1'  comment '是否开启，1开启。0关闭',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pay_code` (`pay_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 2017-2-5
CREATE TABLE tp_order
(
	id mediumint unsigned not null auto_increment comment 'id',
	user_id mediumint unsigned not null comment '会员的ID',
	order_sn char(25) not null comment '订单号',
	pay_status tinyint unsigned not null default '0' comment '支付状态',
	post_status tinyint unsigned not null default '0' comment '发货状态：0：未发货 1：已发货 2：已收货',
	order_status tinyint unsigned not null default '0' comment '订单状态，0：未确认 1：已确认 2：取消 3：申请退货 4.退货成功 5：正常结束',
	consignee varchar(15) not null comment '收货人姓名',
	tel varchar(20) not null comment '收货人电话',
	address varchar(150) not null comment '收货人地址',
	addtime datetime not null comment '下单时间',
	post_id mediumint unsigned not null comment '送货方式',
	pay_id mediumint unsigned not null comment '支付方式',
	invoice_type varchar(10) not null comment '发票类型',
	invoice_header varchar(30) not null comment '发票抬头',
	invoice_company varchar(30) not null default '' comment '留空或者是单位名称',
	invoice_content varchar(30) not null default '' comment '发票内容',
	total_price decimal(10,2) not null comment '订单总价',
	goods_number smallint unsigned not null comment '订单中商品的数量',
	postage decimal(10,2) not null default '0.00' comment '运费',
	primary key (id),
	foreign key (user_id) references tp_user(user_id) on delete cascade,
	key pay_status(pay_status),
	key post_status(post_status),
	key order_status(order_status)
)engine=InnoDB default charset=utf8 comment '订单基本信息表';

-- 2017-2-5
ALTER TABLE `tp_order`
CHANGE COLUMN `addtime` `add_time`  int(10) NOT NULL COMMENT '下单时间' AFTER `address`;


--创建订单明细表,即商品订单关系表（多对多）2017-2-5
CREATE TABLE tp_order_goods
(
	id mediumint unsigned not null auto_increment comment 'id',
	order_id mediumint unsigned not null comment '订单的id',
	goods_id mediumint unsigned not null comment '商品的id',
	goods_logo varchar(150) not null default '' comment '商品图片',
	goods_name varchar(150) not null comment '商品名称',
	goods_attr varchar(150) not null default '' comment '商品属性字符串',
	price decimal(10,2) not null comment '购物的价格',
	goods_number smallint unsigned not null comment '购买的数量',
	primary key (id),
	foreign key (order_id) references tp_order(id) on delete cascade
)engine=InnoDB default charset=utf8 comment '订单商品表';

-- 2017-2-5
ALTER TABLE `tp_role_node`
ADD PRIMARY KEY (`role_id`, `node_id`);


 -- 创建送货方式表2017-2-6
create table tp_shipping(
	id tinyint unsigned not null auto_increment primary key comment '编号',
	shipping_name varchar(30) not null default '' comment '送货方式名称',
	shipping_desc varchar(255) not null default '' comment '送货方式描述',
	enabled tinyint unsigned not null default 1 comment '是否启用，默认启用'
)engine=MyISAM charset=utf8;



-- 商品评论表
CREATE TABLE `tp_goods_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT comment '用户评论的自增id ',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0' comment '商品对应的是goods的goods_id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' comment '发表该评论的用户的用户id,取值user的user_id',
  `email` varchar(60) NOT NULL DEFAULT '' comment '评论是提交的Email地址,默认取的user的email',
  `user_name` varchar(60) NOT NULL DEFAULT '' comment '取值users的user_name ',
  `comment_rank` tinyint(1) unsigned NOT NULL DEFAULT '0' comment '商品的重星级;只有1到5星;由数字代替;其中5代表5星',
  `content` text NOT NULL comment '评论的内容',
  `images` varchar(150) NOT NULL DEFAULT '' comment '评论图片，用逗号隔开，最多6张',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' comment '评论的时间 ',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' comment '是否被管理员批准显示;1是;0未批准显示 ',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' comment '评论的父节点,取值该表的id字段,如果该字段为0,则是一个普通评论,否则该条评论就是该字段的值所对应的评论的回复',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `goods_id` (`goods_id`),
  foreign key (goods_id) references tp_goods(id) on delete cascade
) engine=InnoDB  DEFAULT CHARSET=utf8 comment '商品评论表';



