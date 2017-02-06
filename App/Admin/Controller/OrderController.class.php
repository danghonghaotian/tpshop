<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/12/14
 * Time: 9:05
 */

namespace Admin\Controller;
use Think\Controller;

class OrderController extends AdminController
{
    public function lst()
    {
        $orderModel =  D('Order');
        $orderBasicInfo =  $orderModel->search();
//        dump($orderBasicInfo);
        $this->assign('orderBasicInfo', $orderBasicInfo['data']);
        $this->assign('page', $orderBasicInfo['page']);
        $this->display();
    }

    /**
     * 订单详情
     * @param $id
     */
    public function detail($id)
    {
        $orderModel =  D('Order');
        $orderDetail = $orderModel->getOrderDetailById($id);
//        dump($orderDetail);
        $this->assign('orderDetail',$orderDetail);
        $this->display();
    }

}