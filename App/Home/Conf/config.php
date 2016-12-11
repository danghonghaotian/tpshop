<?php
return array(
	//'配置项'=>'配置值'
//    'SHOW_PAGE_TRACE'   => false,

    'HTML_CACHE_ON'     =>    true, // 开启静态缓存
    'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
        // 定义格式1 数组方式
        // '静态地址'    =>     array('静态规则', '有效期', '附加规则'),
//        'index:'=>array('Index/{:action}_{id}','60'),
//        'index:'=>array('{:module}/{:controller}_{:action}','60'),
        // 定义格式2 字符串方式
        //'静态地址'    =>     '静态规则',
//        'read'=>array('{id}',60)
    ),
    'company' =>'丹宏昊天',
    'goods_page' => 12

);