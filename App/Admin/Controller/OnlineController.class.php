<?php
/**
 * 钟贵廷
 * 2016-12-25
 */
namespace Admin\Controller;
use Think\Controller;
class OnlineController extends AdminController
{
	
	/**
	 * 列表
	 */
	public function lst($keyword = '')
	{
		$Online = D('Online');
		$data =$Online->search(trim($keyword));
		$this->assign('data', $data['data']);
		$this->assign('page', $data['page']);
		$this->display();
	}

	/**
	 * 添加在线客服
	 */
	public function add()
	{
		if (IS_POST)
		{
			$Online = D('Online');
			// 接收并验证表单
			if ($Online->create())
			{
				// 插入数据库
				if ($Online->add() !== FALSE)
				{
					$this->success('添加成功',U('lst'));
				}
				else
				{
					if (APP_DEBUG)
					{
						echo 'SQL为：'.$Online->getLastSql();
					}
					else
					{
						$this->error('发生失败，请重试！');
					}
				}
			}
			else
			{
				$this->error($Online->getError());  // 输出表单验证失败的原因 
			}
		}
		else
		{
			//显示表单
			$this -> display();	
		}
	}

	/**
	 * 修改在线客服信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function save($id)
	{
		if (IS_POST)
		{
			$Online = M('Online');
			if ($Online->create())
			{
				if ($Online -> save() !== FALSE)
				{
					$this->success('修改成功',U('lst'));
				}
				else
				{
					if (APP_DEBUG)
					{
						echo 'SQL为：'.$Online->getLastSql();
					}
					else
					{
						$this->error('发生失败，请重试！');
					}
				}
			}
			else
			{
				$this->error($Online->getError());
			}
		}
		else
		{
			//根据id查找出对应的一条数据分配到模板中
			$Online = M('Online')->find($id);
			$this->assign('Online',$Online);
			$this -> display();
		}

	}


	/**
	 * 删除在线客服信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete($id)
	{
		$Online = M('Online');
		$Online = $Online->find($id);
		M('Online')->delete($id);
		$this->success('删除成功！');
	}

	/**
	 * 批量删除
	 */
	public function batchDel()
	{
		$goodsModel = M("Online");
		if(I('post.id'))
		{
			$idArr = I('post.id');
			$ids = implode(',',$idArr);
			$goodsModel->delete($ids);
			$this->success('批量删除成功！');
		}
	}

}
?>