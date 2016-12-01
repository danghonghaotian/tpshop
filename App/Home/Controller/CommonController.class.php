<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/20
 * Time: 13:38
 */

namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller
{
    /**
     * 如果没有安装，这跳转到安装模块
     * 如果是手机访问，则跳转到手机模块
     */
    public function __construct()
    {
        // 必须先调用父类的构造函数
        parent::__construct();
        if(TPSIsMobile())
        {
           $this->redirect('Mobile/index/index');
        }
    }
}