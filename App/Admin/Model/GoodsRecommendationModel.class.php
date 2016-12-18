<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/18
 * Time: 22:04
 */
namespace Admin\Model;
use Think\Model;

class GoodsRecommendationModel extends Model
{
    protected $_validate = array(
        array('type_id',"require","请选择发布位置"),
        array('goods_sn',"require","请根据商品goods_sn用逗号分开填写"),
    );


    public function getType()
    {
        $data = array('1'=>'疯狂抢购','2'=>'热卖商品','3'=>'推荐商品','4'=>'猜你喜欢');
        return $data;
    }
}
