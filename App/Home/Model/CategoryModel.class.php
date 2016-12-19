<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/19
 * Time: 20:38
 */

namespace Home\Model;
use Think\Model;

class CategoryModel extends Model
{
    //获取指定的二级子类
    public function getSecondCate($id)
    {
        $cateInfo = $this->where(array('parent_id'=>$id))->select();
        return $cateInfo;
    }
}