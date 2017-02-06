<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/6
 * Time: 16:24
 */

namespace Admin\Model;
use Think\Model;
class ShippingModel extends Model
{
    protected $_validate = array(
        array('shipping_name',"require","配送方式名称必填!"),
        array('enabled',"require","是否开启必选"),
    );

    public function search()
    {
        $where = 1;
        $count = $this->where($where)->count();
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '家快递公司';
        $pageStr = $page->fpage();
        $data = $this->where($where)->limit( $page->limit)->order("id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }
}