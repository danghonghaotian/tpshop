<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/27
 * Time: 17:48
 */

namespace Home\Controller;
use Think\Controller;
class CartController extends CommonController
{
    /**
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('404,该页面不存在',U('Home/Index/index'),1);
    }

    
    public function index()
    {
//        dump($_POST);
        $this->display();
    }

    public function flow2()
    {
        $this->display();
    }

    public function flow3()
    {
        $this->display();
    }
}