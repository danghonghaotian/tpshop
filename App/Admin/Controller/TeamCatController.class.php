<?php
/**
 * 团队分类控制器
*/
namespace Admin\Controller;
use Think\Controller;
class TeamCatController extends AdminController
{
	
	/**
	 * 列表
	 */
	public function lst()
	{
		$teamCat = M('TeamCat')->select();
		$this->assign('teamCat', $teamCat);
		$this->display();
	}

	/**
	 * 添加团队分类
	 */
	public function add()
	{
		if (IS_POST)
		{
			$TeamCat = D('TeamCat');
			// 接收并验证表单
			if ($TeamCat->create())
			{
				// 插入数据库
				if ($TeamCat->add() !== FALSE)
				{
					$this->success('添加成功',U('lst'));
				}
				else
				{
					if (APP_DEBUG)
					{
						echo 'SQL为：'.$TeamCat->getLastSql();
					}
					else
					{
						$this->error('发生失败，请重试！');
					}
				}
			}
			else
			{
				$this->error($TeamCat->getError());  // 输出表单验证失败的原因 
			}
		}
		else
		{
			$TeamCat = M('TeamCat')->select();
			$this->assign('TeamCat', $TeamCat);
			//显示表单
			$this -> display();	
		}

	}

	/**
	 * 修改团队分类信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function save($id)
	{
		if (IS_POST)
		{
			$TeamCat = M('TeamCat');
			if ($TeamCat->create())
			{
				if ($TeamCat -> save() !== FALSE)
				{
					$this->success('修改成功',U('lst'));
				}
				else
				{
					if (APP_DEBUG)
					{
						echo 'SQL为：'.$TeamCat->getLastSql();
					}
					else
					{
						$this->error('发生失败，请重试！');
					}
				}
			}
			else
			{
				$this->error($TeamCat->getError());
			}
		}
		else
		{
			//根据id查找出对应的一条数据分配到模板中
			$teamCat = M('TeamCat')->find($id);
			$this->assign('teamCat',$teamCat);
			$this -> display();
		}
	}


	/**
	 * 删除团队分类信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete($id)
	{
		$TeamCat = M('TeamCat');
		$TeamCat->delete($id);
		$this->success('删除成功！');
	}

}
?>