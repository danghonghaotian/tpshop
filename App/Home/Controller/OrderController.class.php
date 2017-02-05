<?php
/**
 * User: 钟贵廷
 * Date: 2017/1/1
 * Time: 15:14
 */
namespace Home\Controller;
use Think\Controller;
class OrderController extends MemberCommonController
{
    /**
     * 订单展示
     */
    public function index()
    {
        $this->display();
    }


    /**
     * 填写核对订单信息
     */
    public function flow1()
    {
        //收货人信息
        $addressModel = D('Address');
        $userAddressInfo = $addressModel->getUserAddressInfo();
//        dump($userAddressInfo);
        $this->assign('userAddressInfo', $userAddressInfo);

        //支付方式
        $paymentModel = D('Payment');
        $payment = $paymentModel->getPaymentInfo();
//        dump($payment);
        $this->assign('payment', $payment);

        //商品清单信息
        $cartModel = D('Cart');
        $goods = $cartModel->get();
        $this->assign('goods', $goods);
        $this->display();
    }

    /**
     * 提交订单
     */
    public function flow2()
    {
        dump($_POST);
        if(IS_POST)
        {
            $orderModel = D('Order');
            $orderModel->finishShopping();
        }
    }





}