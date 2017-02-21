<?php
/**
 * User: 钟贵廷
 * Date: 2017/2/21
 * Time: 20:35
 *
 * Oscar活动页面
 */

namespace Activity\Controller;
use Think\Controller;

class OscarController extends Controller
{
    public function  index()
    {
        $activityModel = D('Activity');
        $data =$activityModel->find('10001');
        $img_path = '/assets/activities/images/2017/2017-02/oscar';
//        dump($data);
        $goodsModel = D('Goods');
        $goods = $goodsModel->getActivityGoodsInfo($data['goods_sn']);
//        dump($goods);
        $this->assign('data',$data);
        $this->assign('goods',$goods);
        $this->assign('img_path',$img_path);

        $this->display();
    }
}