<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/10
 * Time: 9:44
 */
namespace Admin\Model;
use Think\Model;
class ArticleCatModel extends Model
{

    protected $_validate = array(
        array('cat_name',"require","文章分类名称号必须!"),
    );

    /**
     *@access private
     *@param $arr array 要遍历的数组
     *@param $pid 节点的pid，默认为0，表示从顶级节点开始
     *@param $level int 表示层级 默认为0
     *@param array 排好序的所有后代节点
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
                $this->tree($arr,$v['cat_id'],$level + 1);
            }
        }
        return $tree;
    }



    /**
     *  根据父类id查出所有子类的数组
     * @param $arr
     * @param $parent_id
     * @return array
     */
    public function getAllSubCatByParentId($arr,$parent_id)
    {
        static $subs=array();
        foreach($arr as $v)
        {
            if($v['parent_id']==$parent_id)
            {
                $subs[]=$v;
                $this->getAllSubCatByParentId($arr,$v['cat_id']);
            }
        }
        return $subs;
    }

    /**
     * 根据子类id找出所有包含子类与父类的数组
     * @param $arr
     * @param $cat_id
     * @return array
     */
    public function getAllParentCatByCatId($arr,$cat_id)
    {
        static $cat = array();
        foreach ($arr as $v)
        {
            if($v['cat_id'] == $cat_id)
            {
              $cat[] = $v;
              $this->getAllParentCatByCatId($arr, $v['parent_id']);
            }
        }
        return $cat;
    }

    /**
     * @return array
     */
    public function getCatType()
    {
        $cat_type = array();
        $cat_type['1'] = '普通分类';
        $cat_type['2'] = '系统分类';
        $cat_type['3'] = '网店信息';
        $cat_type['4'] = '帮助分类';
        $cat_type['5'] = '网店帮助';
        return $cat_type;
    }

    /**
     * 获取分类名称
     * @return array
     */
    public function getCatName()
    {
        $cat = array();
        $data =  $this->field("cat_id,cat_name")->select();
        foreach ($data as $k=>$v)
        {
            $cat[$v["cat_id"]] = $v["cat_name"];
        }
        $cat[-1] = "保留";
        return $cat;
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
                $cateId[] = $v['cat_id'];
                $cateId = array_merge($cateId, self::getAllChildIdByPid($arr, $v['cat_id']));
            }
        }
        return $cateId;
    }



    /**
     *根据pid获取所有的子id
     * 包含父id
     * @param $arr
     * @param $parent_id
     * @return array
     */
    public function getAllIdByPid($arr,$parent_id)
    {
        static $cateId = array();
        $cateId[] = (string)$parent_id;
        foreach($arr as $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                $cateId[] = $v['cat_id'];
                $cateId = $this->getAllIdByPid($arr, $v['cat_id']);
            }
        }
        return array_unique($cateId);
    }

    /**
     * 根据子类id获取父类数据
     * @param $arr
     * @param $cat_id
     * @return array
     */
    static public function getParentCateByCatId ($arr, $cat_id)
    {
        $parentData = array();
        foreach($arr as $v)
        {
            if($v['cat_id'] == $cat_id)
            {
                $parentData = array_merge($parentData, self::getParentCateByCatId($arr, $v['parent_id']));
                $parentData[] = $v;
            }
        }
        return $parentData;
    }

    /**
     *根据子类id查找出所有的父id
     * @param $arr
     * @param $cat_id
     * @return array
     */
    public function getAllIdByCatId($arr,$cat_id)
    {
        static $cateId = array();
        foreach($arr as $v)
        {
            if($v['cat_id'] == $cat_id)
            {
                if($v['parent_id'] != 0)
                {
                    $cateId[] = $v['parent_id'];
                    $cateId = $this->getAllIdByCatId($arr, $v['parent_id']);
                }
            }
        }
        return $cateId;
    }

}