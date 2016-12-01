<?php
define('APP_DEBUG', true);  //调试模式
define('APP_PATH', './App/');
header('content-type:text/html;charset=utf-8');

//进入安装目录
if(is_dir("Install") && !file_exists("Install/install.ok")){
    header("Location:Install/index.php");
    exit();
}

require './ThinkPHP/ThinkPHP.php';



