<?php
/**
 * 登录控制器
 * User: 钟贵廷
 * Date: 2016/12/27
 * Time: 21:43
 */

namespace TPH\Controller;
use Think\Controller;

class AdminController extends Controller
{
    public function _empty()
    {
        $this->redirect('Home/Index/index');
    }

    public function login()
    {
        $pwd = md5(I('post.pwd'));
        if(I('post.username') == 'admin' && $pwd == 'e341bf4ea446ad19a2bd6b5370ec4a58')
        {
            session('test','test');
            $this->redirect('TPH/Index/index');
        }
        
        $this->display();
    }
        
    
        
}