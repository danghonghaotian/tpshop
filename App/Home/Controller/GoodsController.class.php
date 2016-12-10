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
    public function lst()
    {
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

        $this->display();
    }


}
