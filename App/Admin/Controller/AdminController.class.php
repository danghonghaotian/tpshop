<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/16
 * Time: 11:28
 */

namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller
{
    /**
     * 空操作是指系统在找不到请求的操作方法的时候，
     * 会定位到空操作（_empty）方法来执行，利用这个机制，
     * 我们可以实现错误页面和一些URL的优化。
     */
    public function _empty()
    {
        $this->redirect('Admin/Index/index');
    }

    public function __construct()
    {
        // 必须先调用父类的构造函数
        parent::__construct();
        if(!session('?userId'))
        {
            // 从cookie中取出用户名和密码
            $username = cookie('username');
            $password = cookie('password');
            // 从COOKIE中找有没有用户名，密码，如果有就直接登录
            if($username && $password)
            {
                $model = D('AdminMember');
                // 把用户名和密码赋值给管理员模型，并执行非空的验证
                if($model->create(array(
                    'username' => $username,
                    'password' => $password,
                )))
                {
                    if($model->login() === TRUE)
                    {
                        $this->redirect(U('/Admin/Index/index'));
                        exit;
                    }
                }
            }
            $this->error('必须先登录', U('Admin/Manager/login'));
        }
        $this->checkPrivilege();
    }

    /**
     * 权限校验
     * @return bool
     */
    public function checkPrivilege()
    {
        $privilege = session('privilege');
        $username = session('username');
        //admin管理员拥有所有权限
        if($username != 'admin')
        {
            if(CONTROLLER_NAME == 'Index')
                return TRUE;
            // 先取出当前用户请求的控制器和方法名
            $accessArr = array(MODULE_NAME,CONTROLLER_NAME,ACTION_NAME);
            if(!in_array($accessArr, $privilege))
            {
                $this->error('无权访问');
            }
        }
    }


}
