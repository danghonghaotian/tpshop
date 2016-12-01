<?php
/**
 * 跃飞科技版权所有 @2016
 * Date: 2016/9/24
 * Time: 9:47
 * Curl请求类
 */

namespace Helper;
class Curl
{
    /**
     * 发送get请求
     * @param $url
     * @return mixed
     * 返回请求的页面结果
     */
    public function getRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //0表示把结果输出，1不输出结果，而是返回
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err)
        {
            echo "cURL Error #:" . $err;
        }
        else
        {
            return $result;
        }
    }


    /**
     * 发送post请求
     * @param $url
     * @param $arr
     * @return mixed
     */
    public function postRequest($url,$arr)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //0表示把结果输出，1不输出结果，而是返回
        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        $result =  curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}