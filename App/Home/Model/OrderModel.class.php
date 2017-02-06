<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/5
 * Time: 17:31
 */
namespace Home\Model;
use Think\Model;

class OrderModel extends Model
{
    /**
     * 保存提交订单信息
     */
    public function finishShopping()
    {
        $flag = false;
        //根据address_id 找出详情
        $addressModel = D('Address');
        $consigneeInfo = $addressModel->getConsigneeInfo(I('address_id'));
//        dump($consigneeInfo);
        //找出购物车中的商品
        $cartModel = D('Cart');
        $goods = $cartModel->get();
//        dump($goods);
        $this->user_id = session('user_id'); //会员的ID
        $this->order_sn = date('Ymd').uniqid(); //订单号
        $this->pay_status = 0; //支付状态
        $this->post_status = 0; //发货状态：0：未发货 1：已发货 2：已收货
        $this->order_status = 0; //订单状态，0：未确认 1：已确认 2：取消 3：申请退货 4.退货成功 5：正常结束
        $this->consignee = $consigneeInfo['consignee']; //收货人姓名
        $this->tel = $consigneeInfo['tel']; //收货人电话
        $this->address = $consigneeInfo['address']; //收货人地址
        $this->add_time = time(); //下单时间
        $this->post_id = 0; //送货方式
        $this->pay_id = I('pay_id'); //支付方式
        $this->invoice_type = I('invoice_type');  //发票类型
        $this->invoice_header = I('invoice_header'); //发票抬头
        $this->invoice_company = I('invoice_company'); //留空或者是单位名称
        $this->invoice_content = I('invoice_content'); //发票内容
        $this->total_price = I('total_price'); //订单总价
        $this->goods_number = I('goods_number'); //订单中商品的数量
        $this->postage = I('postage'); //运费

        $order_id = $this->add();


        //创建订单明细表
        if($order_id>0)
        {
            $data = array();
            foreach ($goods as $k=>$v)
            {
                $data[$k]['order_id'] = $order_id;
                $data[$k]['goods_id'] = $v['goods_id'];
                $data[$k]['goods_logo'] = $v['sm_logo'];
                $data[$k]['goods_name'] = $v['goods_name'];
                $data[$k]['goods_attr'] = $v['goods_attr_str'];
                $data[$k]['price'] = $v['shop_price'];
                $data[$k]['goods_number'] = $v['goods_number'];
            }

            $orderGoodsModel = D('OrderGoods');
            $num = $orderGoodsModel->addAll($data);
            if($num >0)
            {
                //清空购物车商品
                self::clearCar();
                //减去相应的库存
                self::minusGoodsNum();
                $flag = true;
            }
        }

        return $flag;

    }

    /**
     * 清空购物车
     */
    private static function clearCar()
    {
        $cartModel = D('Cart');
        $cartModel->where(array('user_id'=>session('user_id')))->delete();
    }


    /**
     * 减去相应的库存量
     */
    private static function minusGoodsNum()
    {

    }

    /**
     * 获取用户订单列表
     */
    public function getOrderInfo()
    {
        $orderInfo = $this->where(array('user_id'=>session('user_id')))->order('add_time desc')->select();
        $arr = array();
        foreach ($orderInfo as $k=>$v)
        {
            $arr[$k] = $v;
            $arr[$k]['goods'] = self::getOrderGoods($v['id']);
        }

        return $arr;

    }


    /**
     * 获取订单下的商品
     * @param $id
     * @return array
     */
    private static function getOrderGoods($id)
    {
        $orderGoodsModel = M('OrderGoods');
        $orderGoods = $orderGoodsModel->where(array('order_id'=>$id))->select();
        return $orderGoods;
    }
}