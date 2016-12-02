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
