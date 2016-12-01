<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/13
 * Time: 11:51
 */
namespace Admin\Controller;
use Think\Controller;
class RoleController extends AdminController
{
    public function lst()
    {
        $role_model = D('Role');
        $role_data = $role_model->select();
        $this->assign('role_data',$role_data);
        $this->display();
    }

    /**
     * 添加角色
     * 将节点信息赋值到模板，并做成child数组
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Role');
            // 接收并验证表单
            if($model->create())
            {
                // 插入数据库
                if(($role_id = $model->add()) !== FALSE)
                {
                    $arr = array();
                    foreach ($_POST['node_id'] as $node_id)
                    {
                        $arr[] = array('role_id'=>$role_id,'node_id'=>$node_id);
                    }
                    $role_node_model = M('RoleNode');
                    //添加数据到节点与角色的中间表
                    foreach ($arr as $v)
                    {
                        $role_node_model->add($v);
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
        $node_model = D('Node');
        $node_data =  $node_model->field('id,title,pid')->select();
        $node_data  = $node_model::getChildArr($node_data);
        $this->assign('node_data',$node_data);
        $this->display();
    }

    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Role');
            if($model->create())
            {
                //删除中间表的数据
                $roleNodeModel = M('RoleNode');
                $roleNodeModel->where(array('role_id'=>$id))->delete();
                //收集表单数据重新添加
                $arr = array();
                foreach ($_POST['node_id'] as $node_id)
                {
                    $arr[] = array('role_id'=>$id,'node_id'=>$node_id);
                }
                //添加数据到权限与角色的中间表
                foreach ($arr as $v)
                {
                    $roleNodeModel->add($v);
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

        $role_model = D('Role');
        $role_data =  $role_model->relation(true)->find($id); //使用关联模型查找数据
        //重构数组,该角色拥有的节点数组
        $nodeArr = array();
        foreach ($role_data['node'] as $v)
        {
            $nodeArr[] = $v['id'];
        }
        $this->assign('node_arr',$nodeArr);
        $this->assign('role_data',$role_data);
        $node_model = D('Node');
        $node_data =  $node_model->field('id,title,pid')->select();
        $node_data  = $node_model::getChildArr($node_data);
        $this->assign('node_data',$node_data);
        $this->display();
    }

    /**
     * 删除角色
     * 1、角色下面有管理员的话，提示先删管理员，再删角色
     * 2、删除角色的同时，把节点与角色的中间表对应的数据删除
     * @param $id
     */
    public function delete($id)
    {
        $roleModel = D('Role');
        $role_data =  $roleModel->find($id);
        if(empty($role_data))
        {
            $this->error('手贱，滚！');
        }
        else
        {
            //根据id查找关联的用户
            $arr =   $roleModel->getAdminMemberIdByRoleId($id);
            if(!empty($arr))
            {
                $this->error('该角色下面还有管理员，需要先删除管理员哦');
            }
            else
            {
                $roleModel->delete($id);
                $roleNode = M('RoleNode');
                //删除中间表role_node数据
                $roleNode->where(array('role_id'=>$id))->delete();
                $this->success('删除成功！');
            }
        }
    }


    public  function test()
    {
        $role_model = D('Role');
        $arr =  $role_model->getAllRoleName();
        var_dump($arr);
    }
    public  function test1()
    {
        $role_model = D('Role');
        $arr =  $role_model->getRoleIdByAdminMemberId(6);
        var_dump($arr);
    }

    public  function test2()
    {
        $role_model = D('Role');
        $arr =  $role_model->getAdminMemberIdByRoleId(1);
        var_dump($arr);
    }



}

