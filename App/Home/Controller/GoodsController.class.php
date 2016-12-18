<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/27
 * Time: 17:16
 */
namespace Home\Controller;
use Think\Controller;
class GoodsController extends CommonController {
    
    /**
     * 商品列表页
     */
    public function lst($cid=0)
    {
        /****找出分类商品****/
        $goodsModel = D('Goods');
        $categoryModel = M('Category');
        $category = $categoryModel ->select();
        $ids = $goodsModel->getAllIdByPid($category,$cid);
        $goods = $goodsModel->search($ids);
        $this->assign('goods',$goods['data']);
        $this->assign('page',$goods['page']);

        //面包屑
        $cate = $goodsModel->getAllParentCatByCatId($category,$cid);
        $this->assign('cate',$cate);

        //分类标题
        $cateData = $categoryModel->find($cid);
        $this->assign('title',$cateData['cat_name']);


        $this->display();
    }

    /**
     * 商品详细页
     */
    public function detail($id)
    {
        //商品基本信息
        $goodsModel = D('Goods');
        $goodsInfo = $goodsModel->find($id);
        $this->assign('goodsInfo',$goodsInfo);
        //商品相册
        $goodsGalleryModel = M('GoodsGallery');
        $goodsGallery = $goodsGalleryModel->where(array('goods_id'=>$id))->select();
        $this->assign('goodsGallery',$goodsGallery);

        //商品属性(单选属性)
        $data =  $goodsModel->getGoodsAttrRadioData($id);
        $this->assign('goods_attr',$data);
        //商品唯一属性
        $unitAttr =  $goodsModel-> getUnitAttrByGoodsId($id);
        $this->assign('unitAttr',$unitAttr);

        //面包屑
        $categoryModel = M('Category');
        $category = $categoryModel ->select();
        $cate = $goodsModel->getAllParentCatByCatId($category, $goodsInfo['cat_id']);
//        dump($cate);
        $this->assign('cate',$cate);

        //商品品牌
        $brandModel = M('Brand');
        $brandName = $brandModel->getFieldByBrandId($goodsInfo['brand_id'],'brand_name');
        $this->assign('brandName',$brandName);

        
        $this->display();
    }


}
