<?php
/**
 * 会员中心公共类库，必须登录才能访问
 * User: 钟贵廷
 * Date: 2017/1/1
 * Time: 11:04
 */


namespace Home\Controller;
use Think\Controller;
class MemberCommonController extends CommonController
{
    public function __construct()
    {
        // 必须先调用父类的构造函数
        parent::__construct();

        if(!session('?user_id'))
        {
            // 从cookie中取出用户名和密码
            $email = cookie('user_email');
            $password = cookie('user_password');
            // 从COOKIE中找有没有用户名，密码，如果有就直接登录
            if($email && $password)
            {
                $model = D('User');
                // 把用户名和密码赋值给管理员模型，并执行非空的验证
                if($model->create(array(
                    'email' => $email,
                    'password' => $password,
                )))
                {
                    if($model->login() === TRUE)
                    {
                        $this->redirect(U('/Home/Member/index'));
                        exit;
                    }
                }
            }
            $this->error('没有登录',U('/Home/User/login'));
        }
    }
}
