<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/19
 * Time: 19:17
 */

namespace Home\Model;
use Think\Model;

class GoodsRecommendationModel extends Model
{
    const CRAZY = 1; //疯狂抢购
    const HOT = 2; //热卖商品
    const RECOMMEND = 3; //推荐商品
    const GUESS = 4; //猜你喜欢

    //疯狂抢购
    public function getCrazyGoods()
    {
        $data = $this->where(array('type_id'=>self::CRAZY))->find();
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        foreach ($goods as $k=>$v)
        {
          $key = array_search($v['goods_sn'],$goodsArr );
          $goods[$k]['sort'] = $key;
        }

        usort($goods,'goods_sort');

        return $goods;
    }

    //热卖商品
    public function getHotGoods()
    {
        $data = $this->where(array('type_id'=>self::HOT))->find();
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        foreach ($goods as $k=>$v)
        {
            $key = array_search($v['goods_sn'],$goodsArr );
            $goods[$k]['sort'] = $key;
        }
        usort($goods,'goods_sort');
        return $goods;
    }

    //推荐商品
    public function getRecommendGoods()
    {
        $data = $this->where(array('type_id'=>self::RECOMMEND))->find();
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        foreach ($goods as $k=>$v)
        {
            $key = array_search($v['goods_sn'],$goodsArr );
            $goods[$k]['sort'] = $key;
        }
        usort($goods,'goods_sort');
        return $goods;
    }


    //猜你喜欢
    public function getGuessGoods()
    {
        $data = $this->where(array('type_id'=>self::GUESS))->find();
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        foreach ($goods as $k=>$v)
        {
            $key = array_search($v['goods_sn'],$goodsArr );
            $goods[$k]['sort'] = $key;
        }
        usort($goods,'goods_sort');
        return $goods;
    }

    /**
     * 获取封面图片的方法（测试用）
     * @param $goodsModel
     * @param $goods_id
     * @return string
     */
    private static function getIndexPic($goodsModel,$goods_id)
    {
        $indexPic = '';
        $goodsGalleryModel = M('GoodsGallery');
        $goodsGallery = $goodsGalleryModel->where(array('goods_id'=>$goods_id))->select();
        if(!empty($goodsGallery))
        {
            $indexPic =  $goodsGallery[0]['sm1_logo'];
        }
        else
        {
            $goods = $goodsModel->find($goods_id);
            $indexPic = $goods['sm1_logo'];
        }
        return $indexPic;
    }


}