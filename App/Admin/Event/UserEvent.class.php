<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/9/13
 * Time: 17:10
 */

namespace Admin\Event;
use Think\Controller;
class UserEvent extends Controller
{
    public function test()
    {
        echo '内部事件控制器，不能给外部通过浏览器访问';
    }
}