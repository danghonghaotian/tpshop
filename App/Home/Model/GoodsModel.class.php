<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/10
 * Time: 20:42
 */

namespace Home\Model;
use Think\Model;

class GoodsModel extends Model
{

    /**
     * 获取商品的单选属性数据
     * @param $id
     * @return array
     */
    public function getGoodsAttrRadioData($id)
    {
        $prefix = C('DB_PREFIX');
        $sql = 'SELECT a.id,a.goods_id,a.attr_id,a.attr_value,a.attr_price,b.attr_name,b.attr_type,b.goods_type_id from '.$prefix.'goods_attr as a LEFT JOIN '.$prefix.'attribute as b on  a.attr_id = b.id WHERE goods_id ='.$id.' and attr_type = 1';
        $attr =  M()->query($sql);
        $data = array();
        foreach ($attr as $k=>$v)
        {
            $data[$v['attr_name']][] = array($v['attr_id'],$v['attr_value']);
        }
        return $data;
    }

    /**
     * 根据子类id找出所有包含子类与父类的数组
     * @param $cate
     * @param $id
     * @return array
     */
    public function getAllParentCatByCatId($cate, $id)
    {
        $arr = array();
        foreach($cate as $v)
        {
            if($v['id'] == $id)
            {
                $arr = array_merge($arr, self::getAllParentCatByCatId($cate, $v['parent_id']));
                $arr[] = $v;
            }
        }
        return $arr;
    }


}