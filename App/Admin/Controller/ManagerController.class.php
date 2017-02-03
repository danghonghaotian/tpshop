<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/15
 * Time: 17:33
 */

namespace Admin\Controller;
use Think\Controller;
class  ManagerController extends Controller
{

    /**
     *
     * @param string $function
     * @param array $vars
     */
    public function __call($function,$vars)
    {
        $this->redirect('Home/Index/index');
    }
    /**
     * 管理员登录
     */
    public function Login()
    {
        if(IS_POST)
        {
            $model = D('AdminMember');
            if($model->create())
            {
                if(($login = $model->login()) === TRUE)
                {
                    $this->success('登录成功', U('Admin/Index/index'));
                    exit;
                }
                else
                {
                    if($login == \Admin\Model\AdminMemberModel::NO_USERNAME)
                        $this->error('用户名不存在');
                    elseif ($login == \Admin\Model\AdminMemberModel::PASSWORD_ERROR )
                        $this->error('密码错误！');
                    else
                        $this->error('未知错误！');
                }
            }
            else
                $this->error($model->getError());
        }
        $this->display();
    }

    /**
     * 管理员退出
     */
    public function logout()
    {
        $model = D('AdminMember');
        $model->logout();
        $this->success('退出啦，下次再来！', U('Admin/Manager/login'));
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
}