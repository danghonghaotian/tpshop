# 2016-12-2
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

#2016-12-6
ALTER TABLE `tp_goods`
ADD COLUMN `goods_number`  smallint(5) UNSIGNED NOT NULL AFTER `goods_name`;
ALTER TABLE `tp_goods`
MODIFY COLUMN `goods_number`  smallint(5) UNSIGNED NOT NULL COMMENT '商品数量' AFTER `goods_name`;

#修改商品sku长度
ALTER TABLE `tp_goods`
MODIFY COLUMN `goods_sn`  char(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品货号' AFTER `shop_price`;

#商品名称要是英文的时候，好长
ALTER TABLE `tp_goods`
MODIFY COLUMN `goods_name`  varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称' AFTER `id`;




# 2016-12-02
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

#删除商品的时候，不删除图片，这样删掉数据表数据就行了 2016-2-10
ALTER TABLE `tp_goods_gallery`
ENGINE=InnoDB;

ALTER TABLE `tp_goods_gallery` ADD CONSTRAINT `tp_goods_gallery_id` FOREIGN KEY (`goods_id`) REFERENCES `tp_goods` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;


# 2016-12-02
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

#2016-12-6
ALTER TABLE `tp_goods_attr`
ADD COLUMN `attr_price`  decimal(8,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '属性额外价' AFTER `attr_value`;


# 2016-12-5
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


#tp_nav 2016-12-11
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


