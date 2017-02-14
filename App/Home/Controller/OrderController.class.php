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
        $orderModel = D('Order');
        $orderInfo = $orderModel->getOrderInfo();
        $this->assign('orderInfo', $orderInfo);
        //dump($orderInfo);
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
     * 支付
     */
    public function flow2()
    {
//        dump($_POST);
        $paymentModel = D('Payment');
        $payCode = $paymentModel->getFieldById(I('pay_id'),'pay_code');
        $controllerName = ucfirst($payCode);
        if(IS_POST)
        {
            $orderModel = D('Order');
            $payInfo = $orderModel->finishShopping();
            if($payInfo)
            {
                //支付宝支付按钮
                if($payCode == 'alipay')
                {
                    $payModel = A($controllerName);
                    $goPay = $payModel->pay($payInfo);
                }
                $this->assign('goPay',$goPay);
                $this->display();
            }
            else
            {
                $this->error('订单提交失败');
            }
        }
    }





}