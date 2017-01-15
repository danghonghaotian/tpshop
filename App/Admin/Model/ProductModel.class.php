<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/01/15
 * Time: 18:52
 */

namespace Admin\Model;
use Think\Model;

class ProductModel extends Model 
{	
	public function add()
	{
		// 先把原来的全部删除掉
		$this->where('goods_id='.$_GET['goods_id'])->delete();
		// 如果商品没有单选属性
		$goods_number = array_sum($_POST['goods_number']);

		if(!isset($_POST['goodsattr_id']))
		{
			parent::add(array(
				'goods_id'=>$_GET['goods_id'],
				'goods_number'=>$goods_number,
				'goodsattr_id'=>'',
			));
		}
		else
		{
			// 先取出所有的属性ID
			$attr_id = array_keys($_POST['goodsattr_id']);
			foreach ($_POST['goodsattr_id'][$attr_id[0]] as $k => $v)
			{
				if($v)
				{
					$_goodsattr = array();
					// 循环每一个属性，拿出ID
					foreach ($attr_id as $k3 => $v3)
					{
						$_goodsattr[] = $_POST['goodsattr_id'][$v3][$k];
					}
					sort($_goodsattr);
					$_goodsattr = implode(',', $_goodsattr);
					parent::add(array(
						'goods_id'=>$_GET['goods_id'],
						'goods_number'=>$_POST['goods_number'][$k],
						'goodsattr_id'=>$_goodsattr,
					));
				}
			}
		}

		//更新商品表的库存量
		$goodsModel = M('Goods');
		$goodsModel-> where(array('id'=>$_GET['goods_id']))->setField('goods_number',$goods_number);
	}
}