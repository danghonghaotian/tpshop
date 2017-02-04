<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2017/1/1
 * Time: 19：05
 */

return array(
    'menu'=>array(
        '订单中心'=>array(
            '我的订单' =>array('Order','index'),
            '我的预售' =>array('Goods','add'),
            '评价晒单' =>array('Goods','add'),
            '取消订单记录' =>array('Goods','add'),
            '我的常购商品' =>array('Goods','add'),
        ),
        '关注中心'=>array(
            '关注的商品' =>array('Members','index'),
            '关注的活动' =>array('Goods','add'),
        ),
        '资产中心'=>array(
            '优惠券' =>array('Memberf','index'),
            '余额' =>array('Goods','add'),
        ),
        '客户服务'=>array(
            '返修/退换货' =>array('Goods','lst'),
            '价格保护' =>array('Goods','add'),
            '我的投诉' =>array('Goods','add'),
            '购买咨询' =>array('Goods','add'),
            '交易纠纷' =>array('Goods','add'),
            '我的发票' =>array('Goods','add'),
            '举报中心' =>array('Goods','add'),
        ),
        '账户设置'=>array(
            '个人信息' =>array('Member','index'),
            '收货地址' =>array('Address','index'),
        ),
    )
);