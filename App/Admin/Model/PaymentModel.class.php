<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/5
 * Time: 11:05
 */

namespace Admin\Model;
use Think\Model;
class PaymentModel extends Model
{

    /**
     * 将配置文件序列化后保存
     * @return bool|false|int
     */
    public function save()
    {
        $this->pay_config = serialize($this->pay_config);
        return parent::save();
    }


    /**
     * 获取反序列化后的信息
     */
    public function getPaymentInfo()
    {
        $payment = $this->select();
        $arr = array();
        foreach ($payment as $k=>$v)
        {
            $arr[$k]['id'] = $v['id'];
            $arr[$k]['pay_code'] = $v['pay_code'];
            $arr[$k]['pay_name'] = $v['pay_name'];
            $arr[$k]['pay_desc'] = $v['pay_desc'];
            $arr[$k]['pay_fee'] = $v['pay_fee'];
            $arr[$k]['pay_order'] = $v['pay_order'];
            $arr[$k]['pay_config'] = unserialize($v['pay_config']);
            $arr[$k]['enabled'] = $v['enabled'];
        }
        return $arr;
    }

    /**
     * 获取反序列化后的详细信息
     * @param array $v
     * @return array
     */
    public function getPaymentDetail(Array $v)
    {
        $arr = array();
        $arr['id'] = $v['id'];
        $arr['pay_code'] = $v['pay_code'];
        $arr['pay_name'] = $v['pay_name'];
        $arr['pay_desc'] = $v['pay_desc'];
        $arr['pay_fee'] = $v['pay_fee'];
        $arr['pay_order'] = $v['pay_order'];
        $arr['pay_config'] = unserialize($v['pay_config']);
        $arr['enabled'] = $v['enabled'];
        return $arr;
    }

}