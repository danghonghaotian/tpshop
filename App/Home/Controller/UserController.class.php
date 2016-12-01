<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/27
 * Time: 16:57
 */
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    /**
     * 用户注册
     */
    public function register()
    {
        $this->display();
    }

    public function login()
    {
        $this->display();
    }

    public function userCenter()
    {
        $this->display();
    }

    /**
     * 测试导出excel格式数据
     */
    public function test()
    {
//        $data = array(
//            array(NULL, 2010, 2011, 2012),
//            array('Q1',   12,   15,   21),
//            array('Q2',   56,   73,   86),
//            array('Q3',   52,   61,   69),
//            array('Q4',   30,   32,    0),
//        );
        $brand = M('Brand');
        $data = $brand->select();
//        var_dump($data);die;
        array2excel($data,'brand.xls');
    }


    public function test1()
    {
        $brandFile = './assets/excel/Spain&Portugal.xlsx';
        $data = excel2array($brandFile);
        foreach ($data as $v)
        {
            $sql = "insert into tp_state (country_id,country,state) VALUES ('$v[0]','$v[1]','$v[2]');";
            echo $sql."<br/>";
        }

//        var_dump($data);
//        M('state')->addAll($data);
    }

    /**
     * 发送邮件测试
     * 已经成功
     */
    public function email()
    {
        $content = file_get_contents('./assets/template/email/test.html');
        set_time_limit(0);
        $flag = sendEmail('845272922@qq.com','钟贵廷','gv活动'.$i,$content);
        if($flag !== true )
        {
            $this->error("发送失败",'',10);
        }
        else
        {
            $this->success('发送成功',U('Home/index/index'));
        }
//        for ($i=0;$i<10;$i++)
//        {
//              //每个2分钟发送一次
//
//              $flag = sendEmail('845272922@qq.com','钟贵廷','gv活动'.$i,$content);
////                if($flag !== true )
////                {
////                    $this->error("发送失败",'',10);
////                }
////                else
////                {
////                    $this->success('发送成功',U('Home/index/index'));
////                }
//             sleep(2000);
//        }
    }


    public function testIP()
    {
        get_client_ip();
//        $ip = TPSRealIp();
        $ipData = TPSIPAddress('218.18.139.1');
//        $ipData = TPSIPAddress($ip);
//        echo $ip;
        echo TPSRealServerIp();
        var_dump($ipData);
    }


    public function kuaidi()
    {
//        $data = queryExpress('tnt','382351534');
        $data = queryExpress('tnt','382351535');
        dump($data);
    }
    
    
    public function test3()
    {
       $testHelper =  new \Helper\Test();
       $data = $testHelper->index();
        echo $data;
    }


    /**
     * 测试curl的post请求
     */
    public function test4()
    {
        if($_POST['name']=='admin')
        {
           echo json_encode(array('test'=>'fdsfsfaf'));
        }
    }

    public function test5()
    {
      $pay =  new \Helper\Pay();
      $money =  $pay->currencyService('USD','CNY',100,true);
      var_dump($money);
    }


    public function test6()
    {
        generateBarCode('wx16110949525510',39);
    }

    public function test7()
    {
        generateQrCode('www.baidu.com');
    }

    public function test8()
    {
        $article = M('Article')->find(7);
//        var_dump($article);
        generatePDF($article['title'],$article['content']);
    }


    public function test9()
    {
        $this->display();
    }

    public function test10()
    {
        $host = "http://stock.market.alicloudapi.com";
        $path = "/hk-stock-history";
        $method = "GET";
        $appcode = "49cec126d762450cb9919f835c6cf391";
//        $appcode = "你自己的AppCode";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "begin=2016-11-01&code=600606&end=2016-11-24";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));

    }

    public function test11()
    {
        $host = "http://stock.market.alicloudapi.com";
        $path = "/realtime-k";
        $method = "GET";
        $appcode = "49cec126d762450cb9919f835c6cf391";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "beginDay=20161124&code=600606&time=day&type=bfq";
//        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        echo (curl_exec($curl));

    }




}