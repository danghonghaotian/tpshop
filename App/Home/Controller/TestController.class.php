<?php
/**
 * 跃飞科技版权所有 @2016
 * Date: 2016/12/12
 * Time: 13:18
 */

namespace Home\Controller;
use Think\Controller;
class TestController extends Controller
{
    /**
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('404,该页面不存在',U('Home/Index/index'),1);
    }

    public function test1()
    {
        $this->last_time = 1481522053;
        if(time() > ($this->last_time + 3600*24*7))
        {
            $this->last_time = time();
        }
        echo time()."<br/>";

    }

    public function test2()
    {
        $this->test1();
        echo  $this->last_time;
    }

    public function test3()
    {
        $time= '2016-12-11';
        echo('你输入的时间是：'.$time.'</br>');
        $lastday=date("Y-m-d",strtotime("$time Sunday"));
        echo('输入的时间星期第一天是：'.date("Y-m-d",strtotime("$lastday - 6 days")).'<br/>');
        echo('输入的时间星期最后一天是：'.$lastday);
    }


    public function test4()
    {
//       $info =  \Home\Component\ImageTool::getImageInfo('E:\php\tpshop\assets\home\images\cart_goods1.jpg');
//        dump($info);
        $info =  \Home\Component\ImageTool::water('E:\backup\desktop\test\index_slide4.jpg','E:\backup\desktop\test\test.jpg','E:\backup\desktop\test\dfsfd.jpg',1,30);
//        $info =  \Home\Component\ImageTool::thumb('E:\backup\desktop\test\index_slide3.jpg','E:\backup\desktop\test\testsss.jpg',200,50);
        dump($info);
//        \Home\Component\ImageTool::captcha();
    }

    public function test5()
    {
        echo session('code');
    }

    public function test6()
    {
        \Home\Component\ImageTool::text('E:\backup\desktop\test\index_slide4.jpg','跃飞科技','E:\php\tpshop\assets\home\font\simkai.ttf');
    }

    public function test7()
    {
       echo  str_replace('world','php','hello world' );
    }

}