<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/12
 * Time: 14:15
 */
namespace Admin\Controller;
use Think\Controller;
class AdminMemberController extends AdminController
{
    public function lst()
    {
       $adminMemberModel =  D('AdminMember');
       $adminMemberData =  $adminMemberModel->select();
        //将用户关联角色id
        $roleModel = D('Role');
        foreach ($adminMemberData as $k=>$v)
        {
            $adminMemberData[$k][role_id] =  $roleModel->getRoleIdByAdminMemberId($v['id']);
        }
       $role_name = $roleModel->getAllRoleName();
       $this->assign('adminMemberData',$adminMemberData);
       $this->assign('role_name', $role_name);
       $this->display();
    }

    /**
     * 添加管理员
     * 同时拥有角色
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('AdminMember');
            // 接收并验证表单
            if($model->create())
            {
                //加密key
                $model->salt = $model->getSalt();
                //加密密码算法
//                $model->password = md5(md5($model->password.$model->salt));
                $model->password = $model->my_md5($model->password);
                if(empty($_POST['role_id']))
                {
                    $this->error('要选角色的哦');
                }
                // 插入数据库
                if(($admin_member_id = $model->add()) !== FALSE)
                {
                    $data = array();
                    foreach ($_POST['role_id'] as $v)
                    {
                        $data[] = array('admin_member_id'=>$admin_member_id,'role_id'=>$v);
                    }
                    $admin_role_model = M('AdminRole');
                    //将用户id跟角色id插入到中间表admin_role
                    foreach ($data as $v)
                    {
                        $admin_role_model->add($v);
                    }
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

        //查找角色
        $roleModel = D('role');
        $roleData = $roleModel->select();
        $this->assign('roleData',$roleData);
        $this->display();
    }

    /**
     * 修改用户
     * @param $id
     */
    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('AdminMember');
            if($model->create())
            {
                //验证角色
                if(empty($_POST['role_id']))
                {
                    $this->error('要选角色的哦');
                }
                //修改时候，根据$id 删除中间表admin_role对应的数据，在添加新的数据到中间表
                $adminRole =  M('AdminRole');
                $adminRole->where(array('admin_member_id'=>$id))->delete();
                //拼装数组
                foreach ($_POST['role_id'] as $v)
                {
                    $data[] = array('admin_member_id'=>$id,'role_id'=>$v);
                }
                //将用户id跟角色id插入到中间表admin_role
                foreach ($data as $v)
                {
                    $adminRole->add($v);
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
        $adminMemberModel = D('AdminMember');
        $adminMemberData =  $adminMemberModel->find($id);
        $this->assign('adminMemberData',$adminMemberData);
        //根据用户id归属那个角色
        $roleModel = D('role');
        $role_id =  $roleModel ->getRoleIdByAdminMemberId($id);
        $this->assign('role_id',$role_id);
        //查找角色
        $roleData = $roleModel->select();
        $this->assign('roleData',$roleData);
        $this->display();
    }

    /**
     * 删除管理员的同时，删除中间表的关联数据
     * admin管理员为超级管理员，不能删除
     * @param $id
     */
    public function delete($id)
    {
       $adminMemberModel = D('AdminMember');
       $admin_data =  $adminMemberModel->find($id);
        if(empty($admin_data))
        {
            $this->error('手贱，滚！');
        }
        else
        {
            if($admin_data['username'] == 'admin')
            {
                $this->error('admin超级管理员不能删');
            }
            else
            {
                $adminMemberModel->delete($id);
                $adminRole = M('AdminRole');
                //删除中间表数据
                $adminRole->where(array('admin_member_id'=>$id))->delete();
                $this->success('删除成功！');
            }
        }
    }

}
