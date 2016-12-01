<?php
/**
 * 跃飞科技版权所有 @2016
 */
$website = "http://www.tpshop.com";
return array(
	//'配置项'=>'配置值'
    //数据库配置
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'tpshop',
    'DB_USER' => 'root',
    'DB_PWD' =>'',
    'DB_PORT' =>'3306',
    'DB_PREFIX' => 'tp_',

    'SESSION_TYPE'=>'Db',

    //让页面显示追踪日志信息
    'SHOW_PAGE_TRACE'   => true,
    //不区分大小写
    'URL_CASE_INSENSITIVE' => false,

    //成功，失败以及异常模板
    'TMPL_ACTION_SUCCESS' => './assets/template/message.php',
    'TMPL_ACTION_ERROR' => './assets/template/message.php',
    'TMPL_EXCEPTION_FILE' => './assets/template/exception.php',

    'css'=> $website.'/assets/admin/styles', //配置后台css
    'js'=> $website. '/assets/admin/js', //配置后台js
    'img'=>$website. '/assets/admin/images', //配置后台图片
    'shopName' =>'丹宏昊天 管理中心',
    'ueditor'=> $website.'/assets/ueditor', //百度编辑器
    'jq-ui' => $website.'/assets/jquery-ui', //jquery-ui插件

    'TMPL_TEMPLATE_SUFFIX'=>'.phtml',
    
    //前台样式配置
    'f-css'=> $website.'/assets/home/style',
    'f-js'=> $website. '/assets/home/js',
    'f-img'=>$website. '/assets/home/images', 

    //电子邮件服务器配置
    'EMAIL_HOST' => 'smtp.exmail.qq.com',
    'EMAIL_USERNAME' => 'gtzhong@gtzhong.com',
    'EMAIL_PASSWORD' => 'abc123,',
    'EMAIL_FROM' => 'gtzhong@gtzhong.com',
    'EMAIL_FROM_NAME' => '跃飞电子商城',
    'EMAIL_SMTP_DEBUG' =>false, //调试模式2是调试模式

    //快递100AppKey配置,请将appkey替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
    'KUAIDI100_APP_KEY'=>'19e73e201a28da53',
);