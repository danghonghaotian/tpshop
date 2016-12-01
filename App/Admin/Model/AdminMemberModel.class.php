<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/13
 * Time: 17:22
 */
namespace Admin\Model;
use Think\Model;
class AdminMemberModel extends Model
{
    const NO_USERNAME = -1;
    const PASSWORD_ERROR = -2;

    protected $_validate = array(
        array('verify', 'check_verify', '验证码不正确', 0, 'callback'),
        array('username',"require","用户名不能为空!"),
//        array('username',"","该用户名已经存在!",self::EXISTS_VALIDATE,'unique'),
        array('password', 'require', '密码不能为空！', 1, 'regex', self::MODEL_INSERT),
    );


    /**
     * 验证码校验
     * @param $code
     * @return bool
     */
    function check_verify($code)
    {
        $verify = new \Think\Verify();
        return $verify->check($code);
    }


    /**
     * 管理员密码加密算法
     * @param $password
     * @return string
     */
    public function my_md5($password)
    {
        $this->password = md5(md5($password.$this->salt));
        return $this->password;
    }

    /**
     * 获取加密KEY
     */
    public function getSalt()
    {
        $arr=range('a','z');
        $arr2 = range(1,9);
        $arr = array_merge($arr,$arr2);
        shuffle($arr);
        return  substr(implode('', $arr), 10,6);
    }

    /**
     * 修改密码
     */
    public function save()
    {
        if(trim($this->password) == '')
        {
            unset($this->password);
        }
        else
        {
            $salt = $this->getSalt();
            $this->salt = $salt;
            $this->password = md5(md5($this->password.$salt));
        }
        parent::save();
    }

    /**
     * 管理员登录
     * @return bool|int
     */
    public function login()
    {
        $password = $this->password;
        //1. 根据用户名查询数据库看有没有这个用户
        $user = $this->where(array('username'=>$this->username))->find();
        //注意这里不能使用静态自动完成加密
        if($user)
        {
            if($user['password'] == $this->my_md5($password))
            {
                // 把用户的ID和用户名存到SESSION中
                session('userId',$user['id']);
                session('username',$user['username']);
                // 如果用户选择要自动登录那么把用户名和密码保存到COOKIE中N
                if(isset($_POST['remember']))
                {
                    cookie('username', $user['username'], 7 * 86400);
                    cookie('password', $password, 7 * 86400);
                }
                /******* 取出权限并存到session中 **********************/
                //根据用户id找出角色id,然后根据角色id找出节点id,最后算出所有权限
                //超级管理员admin拥有所有权限
                $roleModel = D('Role');
                $roleId =  $roleModel -> getRoleIdByAdminMemberId($user['id']);
//                var_dump($roleId);die;
                $roleNodeModel = M('RoleNode');
                $nodeIdData = $roleNodeModel->where(array('role_id'=>array('in',$roleId)))->select();
                $nodeId =array();
                foreach ($nodeIdData as $v)
                {
                    $nodeId[] = $v['node_id'];
                }
                $nodeId =  array_unique($nodeId);
//                var_dump($nodeId);
                $nodeModel = D('Node');
                $data['id'] = array('in',$nodeId);
                $data['rank'] = 3;
                $nodeData = $nodeModel->where($data)->field('id')->select();
                //取出角色id对应的节点方法id
                $nodeId = array();
                foreach ($nodeData as $v)
                {
                    $nodeId[] = $v['id'];
                }
//                echo 'SQL为：'. $nodeModel->getLastSql();
//                var_dump($nodeId);die;
                //获取权限数组
                $nodeArr = $nodeModel->select();
                $privilegeArr  =  $nodeModel->getPrivilegeByNodeId($nodeArr,$nodeId);
                session('privilege', $privilegeArr);
//                var_dump($privilegeArr);die;
                return TRUE;
            }
            else
            {
                return self::PASSWORD_ERROR ;
            }
        }
        else
        {
            return self::NO_USERNAME ;
        }
    }

    /**
     * 退出系统
     */
    public function logout()
    {
        session(null);
        cookie('username',null);
        cookie('password',null);
    }

}