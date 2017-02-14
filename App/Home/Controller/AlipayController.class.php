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
        //获取数据库配置信息
        $paymentModel = D('Payment');
        $payConfig = $paymentModel->getPayConfigByPayCode('alipay');
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $orderNum = 'fsdfsafsaf';
        //订单名称，必填
        $orderName = 'fdsfsaf';
        //付款金额，必填
        $totalPrice = 'fdsfsaf';
        //商品描述，可空
        $goodsDesc = 'fdsafsa';

        //构造要请求的参数数组，无需改动
        $service =  "create_direct_pay_by_user";
        $paymentType = "1";
        $input_charset = "utf-8";
        $parameter = array(
            "service"       => $service,
            "partner"       => $payConfig['partner'],
            "seller_id"  => $payConfig['seller_id'],
            "payment_type"	=> $paymentType,
            "notify_url"	=> $payConfig['notify_url'],
            "return_url"	=> $payConfig['return_url'],
            "anti_phishing_key"=> "",
            "exter_invoke_ip"=> "",
            "out_trade_no"	=> $orderNum,
            "subject"	=> $orderName,
            "total_fee"	=> $totalPrice,
            "body"	=> $goodsDesc,
            "_input_charset"	=> $input_charset
        );
        $alipayConfig = array();
        $alipayConfig['partner'] = $payConfig['partner'];
        $alipayConfig['seller_id'] = $payConfig['seller_id'];
        $alipayConfig['key'] = $payConfig['key'];
        $alipayConfig['notify_url'] = $payConfig['notify_url'];
        $alipayConfig['return_url'] = $payConfig['return_url'];
        $alipayConfig['sign_type'] = 'MD5';
        $alipayConfig['input_charset']= $input_charset;
        $alipayConfig['cacert'] = getcwd().'\\assets\\home\\pem\\alipay_redirect.pem';
        $alipayConfig['transport'] = $payConfig['transport'];
        $alipayConfig['payment_type'] = $paymentType;
        $alipayConfig['service'] = $service;
        $alipayConfig['anti_phishing_key'] = "";
        $alipayConfig['exter_invoke_ip'] = "";

        $alipaySubmit = new \Alipay\AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "支付宝支付");
        echo $html_text;
    }
    
}
