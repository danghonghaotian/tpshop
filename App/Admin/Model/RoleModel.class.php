<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/13
 * Time: 14:43
 */
namespace Admin\Model;
use Think\Model\RelationModel;
class RoleModel extends RelationModel
{
    protected $_validate = array(
        array('name',"require","角色名称必须!"),
        array('name',"/^[a-z]{2,15}$/i","角色名称是英文哦!"),
    );

    //关联属性
    protected $_link = array(
        'node' => array(
            'mapping_type'  =>  self::MANY_TO_MANY,
            'foreign_key' => 'role_id',
            'relation_foreign_key' => 'node_id',
            'relation_table' => 'tp_role_node'
        )
    );

    /**
     * 获取角色对应名称
     * @return array
     */
    public function getAllRoleName()
    {
        $arr = array();
        $roleArr = $this->select();
        foreach ($roleArr as $k=>$v)
        {
            $arr[$v['id']] = $v['name'].'('.$v['remark'].')';
        }
        return $arr;
    }

    /**
     * 根据用户id获取角色id
     * @param $adminMemberId
     * @return array
     */
    public function getRoleIdByAdminMemberId($adminMemberId)
    {
        $adminRole = M('AdminRole');
        $roleData = $adminRole->where(array('admin_member_id'=>$adminMemberId))->select();
        $roleId = array();
        foreach ($roleData as $v)
        {
            $roleId[] = $v['role_id'];
        }
        return $roleId;
    }

    /**
     * 根据角色id获取管理员id
     * @param $roleId
     * @return array
     */
    public function getAdminMemberIdByRoleId($roleId)
    {
        $adminRole = M('AdminRole');
        $AdminMemberData = $adminRole->where(array('role_id'=>$roleId))->select();
        $adminMemberId = array();
        foreach ($AdminMemberData as $v)
        {
            $adminMemberId[] = $v['admin_member_id'];
        }
        return $adminMemberId;
    }

}