<?php
/**
 * 跃飞科技版权所有 @2016
 * User: gtzhong
 * Date: 2016/7/21
 * Time: 13:53
 */
$menu = require 'menu.php'; //后台菜单配置
//$website = "http://www.tpshop.com";
$website = http_type().$_SERVER['SERVER_NAME'];
$config = array(
    //样式配置信息

//    'css'=> $website.'/assets/admin/styles', //配置后台css
//    'js'=> $website. '/assets/admin/js', //配置后台js
//    'img'=>$website. '/assets/admin/images', //配置后台图片
//    'shopName' =>'丹宏昊天 管理中心',
//    'ueditor'=> $website.'/assets/ueditor', //百度编辑器

    //模板后缀名修改
    'TMPL_TEMPLATE_SUFFIX'=>'.phtml',
    'URL_HTML_SUFFIX' => 'html|shtml|xml|do', //伪静态后缀名
    'URL_MODEL'=>  1, //url模式
    'PAGE_SIZE'=>10, //一页几条数据

    //上传图片基本配置
    'UPLOAD_CONFIG' => array(
        'maxSize'    =>    2097152,   //2M
        'saveName'   =>    '',
        'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
        'rootPath'      =>  './', //保存根路径
    ),
    //根物理路径
//    'ROOT_PATH' => str_replace('\\','/',realpath(C('website'))),
    'ROOT_PATH' => $_SERVER['DOCUMENT_ROOT'],
//    'LOAD_EXT_CONFIG' => 'menu', //扩展配置

);
//return $config;
return array_merge(
    $menu,$config
);