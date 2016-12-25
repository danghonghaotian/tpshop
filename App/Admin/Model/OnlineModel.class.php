<?php
/**
 * 钟贵廷
 * 2016-12-25
 */
namespace Admin\Model;
use Think\Model;
class OnlineModel extends Model
{
	protected $_validate = array(
		array('onlinename', 'require', '必须填写客服名称'),
		array('onlinename', '', '客服名称已经存在', 0, 'unique'),
		array('qq', 'require', 'qq不能为空'),
		array('taobao', 'require', '淘宝账户不能为空'),
		array('weixin', 'require', '微信账户不能为空'),
	);


	public function search($keyword)
	{
		// 搜索所有的数据,如果需要搜索其他字段需要自己添加
		$where = 1;
		$where .= " and (onlinename like '%$keyword%' or qq like '%$keyword%' or weixin like '%$keyword%' or taobao like'%$keyword%' )";
		/** 翻页 **********/
		//1 . 算出总的记录数
		$count = $this->where($where)->count();
		// 2. 生成翻页类的对象
		$page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
		$page->config['header'] = '个客服';
		// 3. 生成翻页的字符串：上一页、下一页
		$pageStr = $page->fpage();
		// 4. 取出当前页的数据
		$data = $this->where($where)->limit( $page->limit)->order("sort asc")->select();
		return array(
			'page' => $pageStr,
			'data' => $data,
		);
	}

}
?>