<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/5
 * Time: 17:31
 */
namespace Home\Model;
use Think\Model;

class OrderModel extends Model
{
    /**
     * 保存提交订单信息
     */
    public function finishShopping()
    {
        //根据address_id 找出详情
        $addressModel = D('Address');
        $consigneeInfo = $addressModel->getConsigneeInfo($_POST['address_id']);
        dump($consigneeInfo);
        //找出购物车中的商品
        $cartModel = D('Cart');
        $goods = $cartModel->get();
        dump($goods);
        $this->user_id = session('user_id');
        $this->order_sn = date('Ymd').uniqid();
        $this->pay_status = 0;
        $this->post_status = 0;
        $this->order_status = 0;
        $this->consignee = $consigneeInfo['consignee'];
        $this->tel = session('user_id');
        $this->addtime = session('user_id');
        $this->post_id = session('user_id');
        $this->pay_id = session('user_id');
        $this->invoice_type = session('user_id');
        $this->invoice_header = session('user_id');
        $this->invoice_header = session('user_id');
        $this->invoice_company = session('user_id');
        $this->invoice_content = session('user_id');
        $this->total_price = session('user_id');
        $this->goods_number = session('user_id');
        $this->postage = session('user_id');


    }
}