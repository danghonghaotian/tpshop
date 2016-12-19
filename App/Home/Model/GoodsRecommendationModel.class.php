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
        $data = $this->find(self::CRAZY);
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        shuffle($goods);
        return $goods;
    }

    //热卖商品
    public function getHotGoods()
    {
        $data = $this->find(self::HOT);
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        shuffle($goods);
        return $goods;
    }

    //推荐商品
    public function getRecommendGoods()
    {
        $data = $this->find(self::RECOMMEND);
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        shuffle($goods);
        return $goods;
    }


    //猜你喜欢
    public function getGuessGoods()
    {
        $data = $this->find(self::GUESS);
        $goodsArr = explode(',',$data['goods_sn']);
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('goods_sn'=>array('in',$goodsArr)))->select();
        shuffle($goods);
        return $goods;
    }


}