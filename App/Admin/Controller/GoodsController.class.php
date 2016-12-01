<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/16
 * Time: 13:27
 */
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends AdminController
{
    const RADIO = 1; //单选属性
    const UNIQUE = 0; //唯一属性

    public function lst()
    {
        $this->assign('title','商品列表');
        $this->display();
    }

    public function add()
    {
        //商品分类
        $categoryModel = D('Category');
        $categoryData = $categoryModel->select();
        $categoryData = $categoryModel ->tree($categoryData);
        $this->assign('categoryData',$categoryData);
        //商品品牌
        $brandModel = D('Brand');
        $brandData = $brandModel->order('brand_name asc')->select();
        $this->assign('brandData',$brandData);
        //会员价格
        $userRankModel =  D('UserRank');
        $userRankData =  $userRankModel->select();
        $this->assign('userRankData',$userRankData);
        //商品类型
        $goodsTypeModel = D('GoodsType');
        $goodsTypeData = $goodsTypeModel->select();
        $this->assign('goodsTypeData',$goodsTypeData);

        $this->display();
    }

    public function save()
    {
        $this->display();
    }

    public function delete()
    {

    }

    /**
     * 回收站列表
     */
    public function trashList()
    {

    }

    /**
     * 异步获取商品属性
     * @param $type_id
     */
    public function ajaxGetAttrForm($type_id)
    {
        if($type_id >0)
        {
            $AttributeModel = D('Attribute');
            $attributeData = $AttributeModel->where(array('goods_type_id'=>$type_id))->select();
           foreach ($attributeData as $k=>$v)
           {
               if($v['attr_type'] == self::RADIO) //单选属性
               {
                   $attrValue = explode(',',$v['attr_value']);
                   $str = '';
                   $str .="<tr><td class='label'><a onclick='addANewAttRow(this)' href='javascript:void(0);'>[+]</a>{$v['attr_name']}</td><td><select name='attr_value[]' style='width: 120px;'>";
                   foreach ($attrValue as $v1)
                   {
                       $str .= "<option value=''>$v1</option>";
                   }
                   $str .="</select> 属性价格<input type='text'name='' size='6' /></td></tr>";
                   echo $str;
               }
               if($v['attr_type'] == self::UNIQUE)//唯一属性
               {
                   if(empty($v['attr_value']))
                   {
                       echo "<tr><td class='label'>{$v['attr_name']}</td><td><input type='text' name='attr_value[]' value=''/></td>";
                   }
                   else
                   {
                       $attrValue = explode(',',$v['attr_value']);
                       $str = '';
                       $str .="<tr><td class='label'>{$v['attr_name']}</td><td><select name='attr_value[]'>";
                       foreach ($attrValue as $v1)
                       {
                           $str .= "<option value=''>$v1</option>";
                       }
                       $str .="</select></td></tr>";
                       echo $str;
                   }
               }
           }
        }
        else
        {
            echo 'error';
        }
    }
}