<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/27
 * Time: 12:20
 */
namespace Helper;
class Pay
{
    /**
     * 百度汇率转换（有些不正常）
     * @param string $url
     * @param string $message
     * @param int $status_code
     * @param bool $is_ary
     */
    function currencyService($fromCurrency = 'CNY',$toCurrency = 'USD',$amount = 0,$is_ary=false)
    {
        $url = 'http://apis.baidu.com/apistore/currencyservice/currency?fromCurrency='.$fromCurrency.'&toCurrency='.$toCurrency.'&amount=' . $amount;
        $ch = curl_init();
        $header = array(
            'apikey:ff5d69f75511ea262b064294d78b8202',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $resData = json_decode($res, true);
        $resData = $resData['retData'];
        return $is_ary?$resData:round($resData['convertedamount'], 3);
    }

    /**
     * 汇率转换(雅虎)
     * exchangeRate('EUR','CNY',10);
     * @param $from
     * @param $to
     * @param $money
     * @return mixed
     */
    function exchangeRate($from,$to,$money)
    {
        $codeArray = array(
            "$from$to"
        );
        $codeStr=implode('","', $codeArray);
        $yql="select * from yahoo.finance.xchange where pair in (\"".  $codeStr."\")";
        $q=urlencode($yql);
        $url="https://query.yahooapis.com/v1/public/yql?q=".$q."&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,30);
        if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        $response = curl_exec($ch);
        $responseObj=json_decode($response);
        $list=json_decode(json_encode($responseObj->query->results),TRUE);
        $list=$list['rate'];
        $rate = $list['Rate'];
        return $rate*$money;
    }


}