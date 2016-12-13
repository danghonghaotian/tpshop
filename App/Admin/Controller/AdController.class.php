<?php
/**
 * 广告控制器
 * User: 钟贵廷
 * Date: 2016/12/13
 * Time: 20:26
 */

namespace Admin\Controller;
use Think\Controller;

class AdController extends AdminController
{
    public function lst($keyword = '')
    {
        $adPositionModel =  D('Ad');
        $data = $adPositionModel -> search(trim($keyword));
        $this->assign('ad', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }
}