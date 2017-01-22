<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/27
 * Time: 17:16
 */
namespace Home\Controller;
use Think\Controller;
class GoodsController extends CommonController
{

    /**
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('404,该页面不存在',U('Home/Index/index'),1);
    }

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

        //历史记录
        $goodsHistory = $goodsModel->getGoodsListHistory();
        $this->assign('goodsHistory',$goodsHistory);

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
//        dump($goodsInfo);
        $this->assign('goodsInfo',$goodsInfo);
        //商品相册
        $goodsGalleryModel = M('GoodsGallery');
        $goodsGallery = $goodsGalleryModel->where(array('goods_id'=>$id))->select();
        $this->assign('goodsGallery',$goodsGallery);

        //商品属性(单选属性)
        $data =  $goodsModel->getGoodsAttrRadioData($id);

//        dump($data);
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

        //获取浏览历史
        $goodsHistory = $goodsModel->getGoodsHistory($id);
        $this->assign('goodsHistory',$goodsHistory);
        
        $this->display();
    }

    /**
     * 清空最近浏览过的商品
     */
    public function clearGoodsHistory()
    {
        cookie('goodsHistory',null);
        echo '1';
    }


    /**
     * 商品搜索，注意跟列表页兼容
     * @param string $keyword
     */
    public function search($keyword='')
    {
        if(empty($keyword) || $keyword=='商品名称|商品sku')
        {
            $this->error("请搜索商品名称|商品sku");
        }
        $goodsModel = D('Goods');
        $goods = $goodsModel->search('',$keyword);
        $this->assign('goods',$goods['data']);
        $this->assign('page',$goods['page']);
        $this->display();
    }

    /**
     * 异步获取库存量
     */
   public function ajaxGetGoodsNumber()
   {
       $goods_id = (int)$_POST['goods_id'];
       $goods_number = (int)$_POST['goods_number'];
       $goods_attr_id = $_POST['goods_attr_id'];
       $productModel = D('Product');
       $product = $productModel->where(array('goods_id'=>$goods_id,'goodsattr_id'=>$goods_attr_id))->field('goods_number')->find();
       if($product['goods_number'] >= $goods_number)
       {
           echo $product['goods_number']; //实际库存量
       }
       else //库存不足
       {
            echo '0';
       }
   }


}
