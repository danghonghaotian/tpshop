<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/18
 * Time: 21:02
 */

namespace Home\Model;
use Think\Model;

class AdModel extends Model
{
    /**
     * 获取首页幻灯片区广告图
     * @return mixed
     */
    public function getIndexSlideAd()
    {
        $now = date('Y-m-d H:i:s');
        $where = array('adpos_id'=>1,'start_time'=>array('lt',$now),'end_time'=>array('gt',$now),'enabled'=>1);
        $ad = $this->where($where)->order('id desc')->select();
        return $ad;
    }
}