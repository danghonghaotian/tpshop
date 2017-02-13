<?php
/**
 * User: 钟贵廷
 * Date: 2017/2/13
 * Time: 21:12
 * 支付宝即时到账功能
 */
namespace Home\Controller;
use Think\Controller;
class AlipayController extends Controller
{
    /**
     * 初始化支付宝核心类库
     */
    public function __construct()
    {
        vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.AlipayNotify');
        vendor('Alipay.AlipaySubmit');
    }


    /**
     * 支付宝支付，跳转到支付宝网关
     */
    public function pay()
    {
       
    }
    
}
