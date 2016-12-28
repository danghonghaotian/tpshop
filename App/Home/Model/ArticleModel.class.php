<?php
/**
 * 跃飞科技版权所有 @2016
 * Date: 2016/12/28
 * Time: 12:01
 */

namespace Home\Model;
use Think\Model;

class ArticleModel extends Model
{
    public  function  getArticleInfo()
    {
        $articleCatModel = M('ArticleCat');
        $articleCat = $articleCatModel->where(array('parent_id'=>3))->field('cat_id,cat_name,parent_id')->select();
        foreach ($articleCat as $k=>$v)
        {
            $articleCat[$k]['article'] =  $this->where(array('cat_id'=>$v['cat_id']))->field('article_id,title')->select();
        }
        return $articleCat;
    }

    /**
     * 根据子类id找出所有包含子类与父类的数组(面包屑)
     * @param $cate
     * @param $id
     * @return array
     */
    public function getAllParentCatByCatId($cate, $id)
    {
        $arr = array();
        foreach($cate as $v)
        {
            if($v['cat_id'] == $id)
            {
//                $v['url'] = U('Home/Help/lst',array('cid'=>$v['cat_id']));
                $arr = array_merge($arr, self::getAllParentCatByCatId($cate, $v['parent_id']));
                $arr[] = $v;
            }
        }
        return $arr;
    }

}