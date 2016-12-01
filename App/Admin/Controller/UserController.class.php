<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/16
 * Time: 13:30
 */
namespace Admin\Controller;
use Think\Controller;

class UserController extends AdminController
{
    /**
     * 会员列表
     */
    public function lst()
    {
        $userModel = D('User');
        $data = $userModel -> search();
        $this->assign('user', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();

    }

    /**
     * 添加会员
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('User');
            // 接收并验证表单
            if($model->create())
            {
                $model->reg_time = time();
                $model->password = md5(I('password'));
                // 插入数据库
                if($model->add() !== FALSE)
                {
                    $this->success('添加成功', U('lst'));
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
     * 修改会员信息
     * @param $user_id
     */
    public function save($user_id)
    {
        if(IS_POST)
        {
            $model = D('User');
            if($model->create())
            {
                $password = I('password');
                //用户名为空，则不修改密码
                if(empty($password))
                {
                    unset($model->password);
                }
                else
                {
                     $model->password = md5($password);
                }
                if($model->save() !== FALSE)
                {
                    $this->success('修改成功', U('lst'));
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());
        }

        $userModel = D('User');
        $userData = $userModel -> find($user_id);
        $this -> assign('userData',$userData);
        $this->display();
    }


}