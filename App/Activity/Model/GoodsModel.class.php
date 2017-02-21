<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 21:04
 */
namespace Activity\Model;
use Think\Model;

class GoodsModel extends Model
{
    /**
     * 获取活动商品信息
     * @param $arr
     * @return mixed
     */
    public function getActivityGoodsInfo($arr)
    {
        $goodsArr = explode(',',$arr);
        $arr = array();
        foreach ($goodsArr as $k=>$v)
        {
            $arr[$k] = "'$v'";
        }
        $str =  implode($arr,',' );
        $prefix = C('DB_PREFIX');
        $sql = "SELECT goods.id,goods.goods_name,goods.sm_logo,goods.shop_price,market_price,goods.goods_sn,gallery.sm1_logo as gallery_logo from {$prefix}goods as goods LEFT JOIN {$prefix}goods_gallery as gallery on goods.id = gallery.goods_id  WHERE goods.goods_sn IN ({$str}) GROUP BY goods.id";
        $goods = $this->query($sql);

        foreach ($goods as $k=>$v)
        {
            $key = array_search($v['goods_sn'],$goodsArr );
            $goods[$k]['sort'] = $key;
            $goods[$k]['img'] = $v['gallery_logo']?$v['gallery_logo']:$v['sm_logo'];
        }
        usort($goods,'goods_sort');
        return $goods;
    }
}