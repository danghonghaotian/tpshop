<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/4
 * Time: 13:54
 */

namespace Home\Model;
use Think\Model;

class AddressModel extends Model
{
    /**
     * 处理用户收货信息
     * @return array
     */
    public function getUserAddressInfo()
    {
        $addressInfo = $this->where(array('user_id'=>session('user_id')))->order('is_default desc,consignee')->select();
        $arr = array();
        foreach ($addressInfo as $k=>$v)
        {
            $arr[$k]['id']=$v['id'];
            $arr[$k]['consignee']=$v['consignee'];
            $arr[$k]['location']=self::convertToLocation($v['province'],$v['city'],$v['area']);
            $arr[$k]['address']= $arr[$k]['location'].$v['address'];
            $arr[$k]['is_default']=$v['is_default'];
            $arr[$k]['tel']=substr_replace($v['tel'],'****',3,4);
            $arr[$k]['user_id']=$v['user_id'];
        }
        return  $arr;
    }

    /**
     * 将数字转换成文字（所在地区）
     * @param $province
     * @param $city
     * @param $area
     * @return string
     */
    private static function convertToLocation($province,$city,$area)
    {
        $region = M('Region');
        $province = $region->getFieldByRegionId($province,'region_name');
        $city = $region->getFieldByRegionId($city,'region_name');
        $area = $region->getFieldByRegionId($area,'region_name');
        return "{$province}省{$city}市{$area}";
    }

    /**
     * 设置默认地址
     * @param $id
     * @return bool
     */
    public function setDefault($id)
    {
        //先全部改成0.在选中的改成1
        $this->where(array('user_id'=>session('user_id')))->setField('is_default',0);
        $res =  $this->where(array('user_id'=>session('user_id'),'id'=>$id))->setField('is_default',1);
        return $res;
    }

    /**
     * 获取省份
     */
    public function getProvince()
    {
        $region = M('Region');
        $province = $region->where(array('region_type'=>1))->select();
        return $province;
    }

    /**
     * 添加地址
     * @return mixed
     */
    public function add()
    {
        $this->where(array('user_id'=>session('user_id')))->setField('is_default',0);
        $this->user_id = session('user_id');
        return parent::add();
    }

    /**
     * 删除收货地址
     * @param array|mixed $id
     * @return int|mixed
     */
    public function del($id)
    {
        $res = $this->where(array('user_id'=>session('user_id'),'id'=>$id))->delete();
        return $res;
    }

    /**
     * 获取收货人信息
     * @param $id
     * @return array
     */
    public function getConsigneeInfo($id)
    {
        $consigneeInfo = $this->where(array('id'=>$id,'user_id'=>session('user_id')))->find();
        $location =self::convertToLocation($consigneeInfo['province'],$consigneeInfo['city'],$consigneeInfo['area']);
        $address = $location.$consigneeInfo['address'];
        $arr = array();
        $arr['address'] = $address;
        $arr['tel'] = $consigneeInfo['tel'];
        $arr['consignee'] = $consigneeInfo['consignee'];
        return $arr;
    }
}