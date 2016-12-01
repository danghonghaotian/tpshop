<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/29
 * Time: 14:31
 */

namespace Home\Behaviors;
class testBehavior extends \Think\Behavior{
    //行为参数
    public $options = array();
    //行为执行入口
    public function run(&$param){
        echo '12121212121';
    }
}