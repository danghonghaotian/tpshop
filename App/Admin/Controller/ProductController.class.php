<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/01/15
 * Time: 18:52
 */

namespace Admin\Controller;
use Think\Controller;

class ProductController extends AdminController 
{
	protected static $radioAttr = 1; //单选

	public function lst($goods_id)
	{
		if(IS_POST)
		{
			$model = D('Product');
			if($model->add() !== FALSE)
			{
				$this->success('保存成功');
				exit;
			}
			else 
				if(APP_DEBUG)
				{
					echo 'SQL为：'.$model->getLastSql().' - ERROR:'.mysql_error();
					die;
				}
				else
					$this->error('发生失败，请重试！');
		}
		// 取出这件商品所有的单选的属性
		$sql = 'SELECT a.id,a.attr_id,a.attr_value,b.attr_name FROM '.C('DB_PREFIX').'goods_attr a LEFT JOIN '.C('DB_PREFIX').'attribute b ON a.attr_id=b.id WHERE a.goods_id='.$goods_id.' AND b.attr_type='.self::$radioAttr;
		$m = M('Product');
		$_data = $m->query($sql);
		// 重新处理一下数组的结构
		$data = array();
		foreach ($_data as $k => $v)
		{
			$data[$v['attr_name']][] = $v;
		}
		$this->assign('data', $data);
		// 取出当前这件商品的货品信息
		$proData = $m->where('goods_id='.$goods_id)->select();
		$this->assign('proData', $proData);

		//取出商品标题
		$goods = M('Goods')->field('goods_name')->find($goods_id);
		$this->assign('goodsName', $goods['goods_name']);
		$this->display();
	}
}