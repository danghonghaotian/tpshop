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
//        dump($ids);
        $goods = $goodsModel->search($ids);
//        die;
        $this->assign('goods',$goods['data']);
        $this->assign('page',$goods['page']);

        //面包屑
        $cate = $goodsModel->getAllParentCatByCatId($category,$cid);
        $this->assign('cate',$cate);

        //分类标题
        $cateData = $categoryModel->find($cid);
        $this->assign('title',$cateData['cat_name']);

        //分类数据
        $cateAll = $goodsModel->getChildArr($category);
        $this->assign('cateAll',$cateAll);

        //底部帮助信息
        // 购物保障5
        $articleModel = M('Article');
        $shop_help = $articleModel->field(array('article_id','title'))->where(array('cat_id'=>5))->select();
        $this->assign('shop_help',$shop_help);

        //配送方式
        $delivery = $articleModel->field(array('article_id','title'))->where(array('cat_id'=>8))->select();
        $this->assign('delivery',$delivery);


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
        
        //面包屑
        $categoryModel = M('Category');
        $category = $categoryModel ->select();
        $cate = $goodsModel->getAllParentCatByCatId($category, $goodsInfo['cat_id']);
//        dump($cate);
        $this->assign('cate',$cate);

        //分类数据
        $cateAll = $goodsModel->getChildArr($category);
        $this->assign('cateAll',$cateAll);

        //底部帮助信息
        // 购物保障5
        $articleModel = M('Article');
        $shop_help = $articleModel->field(array('article_id','title'))->where(array('cat_id'=>5))->select();
        $this->assign('shop_help',$shop_help);

        //配送方式
        $delivery = $articleModel->field(array('article_id','title'))->where(array('cat_id'=>8))->select();
        $this->assign('delivery',$delivery);

        $this->display();
    }


}
