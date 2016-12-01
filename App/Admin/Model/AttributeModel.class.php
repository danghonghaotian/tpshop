<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/18
 * Time: 17:09
 */
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model
{
    protected $_validate = array(
        array('attr_name', 'require', '属性名称不能为空'),
        array('attr_type', 'require', '属性类型不能为空'),
        array('goods_type_id', 'require', '商品类型类型不能为空'),
    );
}