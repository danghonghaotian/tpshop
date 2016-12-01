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
}