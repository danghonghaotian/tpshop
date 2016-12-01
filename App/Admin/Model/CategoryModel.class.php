<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/26
 * Time: 14:31
 */
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
    protected $_validate = array(
        array('cat_name',"require","商品分类名称号必须!"),
    );

    /**
     * @param $arr
     * @param int $pid
     * @param int $level
     * @return array
     */
    public function tree($arr,$pid = 0,$level = 0)
    {
        static $tree = array(); #用于保存重组的结果,注意使用静态变量
        foreach ($arr as $v)
        {
            if ($v['parent_id'] == $pid)
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
     *根据pid获取所有的子id
     * 不含pid
     * @param $arr
     * @param $parent_id
     * @return array
     */
    static public function getAllChildIdByPid($arr,$parent_id)
    {
        $cateId = array();
        foreach($arr as $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                $cateId[] = $v['id'];
                $cateId = array_merge($cateId, self::getAllChildIdByPid($arr, $v['id']));
            }
        }
        return $cateId;
    }

}