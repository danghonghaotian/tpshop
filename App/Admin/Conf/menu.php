<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/7/21
 * Time: 13:53
 */

return array(
    'menu'=>array(
        '商品管理'=>array(
            '商品列表' =>array('Goods','lst'),
            '添加新商品' =>array('Goods','add'),
            '商品分类' =>array('Category','lst'),
            '用户评论' =>array('User','comment'),
            '商品品牌' =>array('Brand','lst'),
            '商品类型' =>array('GoodsType','lst'),
            '商品回收站' =>array('Goods','trashList'),
            '图片批量上传' =>array('Pic','upload'),
            '商品批量上传' =>array('Goods','upload'),
            '商品批量导出' =>array('Goods','explode'),
            '商品批量修改' =>array('Goods','edit'),
            '生成商品代码' =>array('Goods','code'),
            '更改加密串' =>array('Goods','key'),
            '商品自动上下架' =>array('Goods','down'),
        ),
        '促销管理'=>array(
            '优惠券类型' =>array('news','lst'),
            '活动管理' =>array('news','lst'),
            '每日清仓' =>array('news','lst'),
        ),
        '订单管理'=>array(
            '订单列表'=>array('Order','lst'),
            '订单查询'=>array('Order','search'),
            '合并订单'=>array('Order','merge'),
            '订单打印'=>array('Order','print'),
            '缺货登记'=>array('Goods','book'),
            '添加订单'=>array('Order','add'),
            '发货单列表'=>array('Invoice','lst'),
            '退货单列表'=>array('ReturnOrder','lst')
        ),
        '广告管理'=>array(
            '广告列表'=>array('Ad','lst'),
            '广告位置'=>array('Ad','position'),
        ),
        '文章管理'=>array(
            '文章分类'=>array('ArticleCat','lst'),
            '文章列表'=>array('Article','lst'),
        ),
        '会员管理'=>array(
            '会员列表'=>array('User','lst'),
            '添加会员'=>array('User','add'),
            '会员等级'=>array('UserRank','lst'),
            '充值和提现申请'=>array('User','recharge'),
            '资金管理'=>array('Fund','lst'),
        ),
        '权限管理'=>array(
            '节点管理'=>array('Node','lst'),
            '管理员列表'=>array('AdminMember','lst'),
            '角色管理'=>array('Role','lst'),
            '办事处列表'=>array('company','lst'),
            '供货商列表'=>array('company','lst'),
        ),
        '系统设置'=>array(
            '商店设置'=>array('company','lst'),
            '会员注册设置'=>array('company','lst'),
            '申请商家管理'=>array('company','lst'),
            '支付方式'=>array('company','lst'),
            '配送方式'=>array('company','lst'),
            '邮件服务器设置'=>array('company','lst'),
            '地区列表'=>array('company','lst'),
            '计划任务'=>array('company','lst'),
            '友情链接'=>array('company','lst'),
            '验证码管理'=>array('company','lst'),
            '文件权限检测'=>array('company','lst'),
            '自定义导航栏'=>array('nav','lst'),
            '站点地图'=>array('company','lst'),
            '图片服务器设置'=>array('company','lst'),
        ),
        '信息管理'=>array(
            '短信列表' =>array('Sms','lst'),
            '短信回收站' =>array('Sms','trashList'),
            '邮件列表' =>array('company','lst'),
        ),
        'ERP接口管理'=>array(
            '接口列表' =>array('company','lst'),
        ),
        '微信平台管理'=>array(
            '微信接口' =>array('company','lst')
        )
    )
);