<?php
/**
 * 跃飞科技版权所有 @2016
 */

/**
 * Created by PhpStorm.
 * User: zhong
 * Date: 2016/7/26
 * Time: 11:51
 */
namespace Admin\Controller;


use Think\Controller;

class IndexController extends  AdminController
{
    public function index()
    {
//        var_dump(session('privilege'));
        $this->display();
    }

    public function top()
    {
        $this->display();
    }

    public function menu()
    {
        $this->display();
    }

    public function main()
    {
        $this->display();
    }

}