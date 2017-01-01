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
            '我的关注' =>array('Goods','add'),
            '浏览历史' =>array('Goods','add'),
            '我的团购' =>array('Goods','add'),
        ),
        '账户中心'=>array(
            '账户信息' =>array('Member','index'),
            '账户余额' =>array('Goods','add'),
            '我的积分' =>array('Goods','add'),
            '收货地址' =>array('Goods','add'),
        ),
        '订单中心2'=>array(
            '返修/退换货' =>array('Goods','lst'),
            '取消订单记录' =>array('Goods','add'),
            '我的投诉' =>array('Goods','add'),
        ),
    )
);