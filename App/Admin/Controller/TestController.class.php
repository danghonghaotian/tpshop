<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/13
 * Time: 17:12
 */
namespace Admin\Controller;
use Think\Controller;

class TestController extends Controller
{
    public function index()
    {
        //访问UserEvent控制器的test方法
        A('User','Event')->test();
    }

    public function test2()
    {
//        访问User控制器的lst方法
//       A('User')->lst();
    }

    public function test3()
    {
        //调用Home模块下User控制器下的register方法
        A('Home/User')->register();
    }
}