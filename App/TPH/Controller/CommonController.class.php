<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/27
 * Time: 20:51
 */
namespace TPH\Controller;
use Think\Controller;

class CommonController extends Controller
{
    public function _empty()
    {
        $this->redirect('Home/Index/index');
    }

    public function __construct()
    {
        if(session('?test'))
        {
            return parent::__construct();
        }
        else
        {
            $this->redirect('TPH/Admin/login');
        }

    }
}

?>