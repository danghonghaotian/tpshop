<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/9/13
 * Time: 17:47
 */
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller
{
    public function index()
    {
       $this->redirect('Admin/Index/index');
    }

    /**
     * 还不确定后台什么原因，不走index
     * @param string $fun
     * @param array $vars
     */
    public function __call($fun,$vars)
    {
        $this->redirect('Admin/Index/index');
    }

}