<?php

$rootPath =  $_SERVER['DOCUMENT_ROOT'];
// 构造图片存放目录的路径
$date = date('Y-m',time());
//目录结构宽高/年月组成
$dir =$rootPath."/assets/upload/editor/$date";
if(!is_dir($dir))
{
    mkdir($dir, 0777,true);
}

return array(

    //图片上传允许的存储目录
    'imageSavePath' => array (
//        'upload1', 'upload2', 'upload3'
         "../../upload/editor/$date"  //存储目录按年份存放，电商商品，过几年要是不要了，可以删了
    )

);