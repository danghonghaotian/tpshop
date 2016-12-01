<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/12
 * Time: 17:25
 */
namespace Admin\Model;
use Think\Model;
class NodeModel extends Model
{
    protected $_validate = array(
        array('node_name',"require","URL名称必须!"),
        array('node_name',"/^[a-z]{2,15}$/i","URL名称是英文哦!"),
        array('title',"require","模块名|控制器|方法必须!"),
        array('title',"/^[\x{4e00}-\x{9fa5}]{2,8}$/u","模块名|控制器|方法必须是中文哦!"),
    );

    public function tree($arr,$pid = 0,$level = 0)
    {
        static $tree = array(); #用于保存重组的结果,注意使用静态变量
        foreach ($arr as $v)
        {
            if ($v['pid'] == $pid)
            {
                //说明找到了以$pid为父节点的子节点,将其保存
                $v['level'] = $level;
                $tree[] = $v;
                //然后以当前节点为父节点，继续找其后代节点
                $this->tree($arr,$v['id'],$level + 1);
            }
        }
        return $tree;
    }

    /**
     * 获取所有子id
     * @param $arr
     * @param $pid
     * @return array
     */
    static public function getAllChildIdByPid($arr,$pid)
    {
        $cateId = array();
        foreach($arr as $v)
        {
            if($v['pid'] == $pid)
            {
                $cateId[] = $v['id'];
                $cateId = array_merge($cateId, self::getAllChildIdByPid($arr, $v['id']));
            }
        }
        return $cateId;
    }

    /**
     * 构造含有child下标的数组
     * @param $cate
     * @param string $name
     * @param int $pid
     * @return array
     */
    static public function getChildArr($cate, $name = 'child', $pid = 0){
        $arr = array();
        foreach($cate as $v){
            if($v['pid'] == $pid){
                $v[$name] = self::getChildArr($cate, $name, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /**
     * 根据子类id(方法)获取权限数组
     * @param $arr
     * @param $cat_id
     * @return array
     */
    public function getAllParentNodeById($arr,$id)
    {
        $node = array();
        foreach ($arr as $v)
        {
            if($v['id'] == $id)
            {
                $node = array_merge($node,$this->getAllParentNodeById($arr, $v['pid']));
                $node[] = $v['node_name'];
            }
        }
        return $node;
    }

    /**
     * 根据节点数组获取权限数组
     * @param $arr
     * @param $nodeId
     * @return array
     */
    public function getPrivilegeByNodeId($arr,$nodeId)
    {
        $privilege = array();
        foreach ($nodeId as $v)
        {
            $privilege[] = $this->getAllParentNodeById($arr,$v);
        }
        return $privilege;
    }


}