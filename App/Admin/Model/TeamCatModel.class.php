<?php
/**
 * 团队分类模型
*/
namespace Admin\Model;
use Think\Model;
class TeamCatModel extends Model{	
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空'),
		array('cat_name', '', '分类名称已经存在', 0, 'unique'),
	);


	/**
	 * 获取团队分类名称
	 * @return array
	 */
	public function getTeamCat()
	{
		$teamCat = $this->select();
		$data = array();
		foreach ($teamCat as $k=>$v)
		{
			$data[$v['id']] = $v['cat_name'];
		}
		return $data;
	}
}
?>