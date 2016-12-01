<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/12
 * Time: 15:33
 */
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model
{
    //模块名称
    public function getModuleName()
    {
        $module = array();
        $module['admin'] = '后台';
        $module['api'] = 'API';
        $module['member'] = '会员';
        return $module;
    }
}