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
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('手贱咯',U('Home/Index/index'),1);
    }

    /**
     * 用户注册
     */
    public function register()
    {
        if(IS_POST)
        {
            $model = D('User');
            // 接收并验证表单
            if($model->create())
            {
                // 插入数据库
                if($model->add() !== FALSE)
                {
                    //发送邮件给用户激活账户
                    $email =base64_encode($_POST['email']);  //将邮箱加密
                    $content = $model->getRegisterTemplate($email,getWebsite());
                    
                    $flag = sendEmail($_POST['email'],'','gv商城激活登陆账户',$content);
                    if($flag)
                    {
                        $this->success('注册成功，请登录邮箱去激活你的账号');
                    }
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql().' - ERROR:'.mysql_error();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());  // 输出表单验证失败的原因
        }

        $this->display();
    }

    /**
     * 用户登录
     * 登陆成功要将购物车商品转换为登陆者购买的商品
     */
    public function login()
    {
        if(session("?user_id"))
        {
            $this->success('已经登录，无需再登录',U('Home/Member/index'));
            die;
        }

        if(IS_POST)
        {
            $model = D('User');
            if($model->create('',$model::MODEL_UPDATE))  //登录不做唯一性验证
            {
                $user = $model->login();
                if($user['success'] == 'ok')
                {
                    //如果购物车中有未登陆时添加的商品，登陆后需要转到数据库保存
                    $cartModel = D('Cart');
                    $cartModel->addCookieGoodsToDatabase($user['user_id']);

                    $this->success('登录成功',  session('redirectUrl'));
                    exit;
                }
                else
                {
                    if($user['status'] == \Home\Model\UserModel::NO_USERNAME)
                        $this->error('还没注册或者还没激活');
                    elseif ($user['status'] == \Home\Model\UserModel::PASSWORD_ERROR )
                        $this->error('用户名或者密码错误！');
                    else
                        $this->error('未知错误！');
                }
            }
            else
                $this->error($model->getError());
        }
        $this->display();
    }


    public function logout()
    {
        $model = D('User');
        $model->logout();
        $this->success('欢迎下次光临', U('Home/Index/index'));
    }


    // 显示验证码图片的方法
    public function verifyImg()
    {
        $arr = array(
            'length'=>4
        );
        $Verify = new \Think\Verify($arr);
        $Verify->entry();
    }
    
    /**
     * 异步验证码校验
     * @param $code
     * @return bool
     */
    public function ajaxCheckCode($code, $id = '')
    {
        $config = array('reset'=>false);
        $verify = new \Think\Verify($config);
        $res = $verify->check($code, $id);
        $this->ajaxReturn($res, 'json');
    }

    /**
     * 异步校验邮箱是否被注册
     * @param $email
     * @return bool
     */
    public function ajaxCheckEmail($email)
    {
       $user = D('User');
       $res = $user->ajaxCheckEmail($email);
       $this->ajaxReturn($res, 'json');
    }


    /**
     * 24小时内激活邮箱
     * @param $email
     */
    public function active($email)
    {
        $email =base64_decode($email);  //将邮箱解密
        $user = D('User');
        //判断注册时间是否过了24小时
        $reg_time = $user->where(array('email'=>$email))->getField('reg_time');
        if($reg_time) //看下有没有这个邮箱
        {
            $now = time();
            if($now - $reg_time < 86400) //注册邮箱一天内有效
            {
                $res = $user->where(array('email'=>$email))->setField('active',1);
                if($res)
                {
                    $this->success('恭喜你激活成功',U('Home/User/login'));
                }
                else
                {
                    $this->error('你已经是本站用户',U('Home/User/login'));
                }
            }
            else
            {
                $this->error('该链接已经失效，请重新注册',U('Home/User/register'));
            }
        }
        else
        {
            $this->error('本站还没有这个用户，来加入我们吧',U('Home/User/register'));
        }
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

    /**
     * 测试跨模块调用模型里的方法
     */
    public function test12()
    {
        $userModel = D('Admin/User');
        $arr = $userModel->test12();
        dump($arr);
    }


    public function test13()
    {
        pConst();
    }




}