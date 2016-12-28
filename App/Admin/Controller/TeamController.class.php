<?php
/**
 * 团队控制器
*/
namespace Admin\Controller;
use Think\Controller;
class TeamController extends AdminController
{
	
	/**
	 * 团队列表页
	 */
	public function lst($keyword = '')
	{
		$teamModel =  D('Team');
		$data = $teamModel -> search(trim($keyword));
		$this->assign('team', $data['data']);
		$this->assign('page', $data['page']);

		$teamCatModel = D('TeamCat');
		$teamCat = $teamCatModel->getTeamCat();
		$this->assign('teamCat', $teamCat);

		$this->display();
	}

	/**
	 * 团队列表页
	 */
	public function trashList($keyword = '')
	{
		$teamModel =  D('Team');
		$data = $teamModel -> search(trim($keyword),0);
		$this->assign('team', $data['data']);
		$this->assign('page', $data['page']);

		$teamCatModel = D('TeamCat');
		$teamCat = $teamCatModel->getTeamCat();
		$this->assign('teamCat', $teamCat);

		$this->display();
	}


	/**
	 * 添加团队
	 */
	public function add()
	{
		if(IS_POST)
		{
			$model = D('Team');
			// 接收并验证表单
			if($model->create())
			{
				$model->upload();
				// 插入数据库
				if($model->add() !== FALSE)
				{
					$this->success('添加成功', U('lst'));
					exit;
				}
				else
				{
					if(APP_DEBUG)
						echo 'SQL为：'.$model->getLastSql().' - ERROR:'.mysql_error();
					else
						$this->error('发生失败，请重试！');
				}
			}
			else
				$this->error($model->getError());  // 输出表单验证失败的原因
		}
		$teamCatModel = D('TeamCat');
		$teamCat = $teamCatModel->select();
		$this->assign('teamCat', $teamCat);
		$this->display();
	}

	/**
	 * 修改团队信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function save($id)
	{
		if(IS_POST)
		{
			$model = D('Team');
			if($model->create())
			{
				$model->upload();
				if($model->save() !== FALSE)
				{
					$this->success('修改成功', U('lst'));
					exit;
				}
				else
				{
					if(APP_DEBUG)
						echo 'SQL为：'.$model->getLastSql();
					else
						$this->error('发生失败，请重试！');
				}
			}
			else
				$this->error($model->getError());
		}
		$teamCatModel = D('TeamCat');
		$teamCat = $teamCatModel->select();
		$this->assign('teamCat', $teamCat);
		$model = D('Team');
		$data = $model->find($id);
		$this->assign('team', $data);
		$this->display();
	}


	/**
	 * 删除团队信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete($id)
	{
		$model = D('Team');
		$model->delete($id);
		$this->success('删除成功！');
	}


	/**
	 * 批量删除
	 */
	public function batchDel()
	{
		if(I('post.id'))
		{
			$idArr =  I('post.id');
			$ids = implode(',',$idArr );
			$team = M('Team');
			$team->delete($ids);
			$this->success("批量删除成功！");
		}
	}

	/**
	 * 离职
	 * @param $id
	 */
	public function trash($id)
	{
		$model = D('Team');
		$model->where(array('id'=>$id))->setField('is_delete',0);
		$this->success("该成员已经离职");
	}

	/**
	 * 批量离职
	 */
	public function batchTrash()
	{
		if(I('post.id'))
		{
			$idArr =  I('post.id');
			$ids = implode(',',$idArr );
			$team = M('Team');
			$team->where(array('id'=>array('in',$ids)))->save(array('is_delete'=>0));
			$this->success("已经批量离职啦！");
		}
	}



	/**
	 * 上传单张图片
	 */
	public function ajaxUpload()
	{
		// 读取上传图片的配置
		$config = C('UPLOAD_CONFIG');
		// 设置上传路径
		$config['savePath'] = '/assets/upload/tmp/';
		$upload = new \Think\Upload($config);
		//图片名称
		$skuName = $_FILES['img']['name'];
		//图片存储目录算法
		if(count(explode('_',$skuName)) == 1)
		{
			$imgName = current(explode('.',$skuName));
		}
		else
		{
			$imgName = current(explode('_',$skuName));
		}

		//上传生成的子目录位置
		$upload->subName =  $imgName.'/original';
		//如果已经存在该文件，先删除再重新上传，也就是同名覆盖
		$uploadFile =C('ROOT_PATH').$config['savePath'].$imgName.'/original/'.$_FILES['img']['name'];
		if(file_exists($uploadFile))
		{
			unlink($uploadFile);
		}
		// 执行上传
		$info = $upload->upload();
		if(!$info)
			die($upload->getError());
		// 设置模型原图地址
		$url = $info['img']['savepath'] . $info['img']['savename'];

		$thumb_path = C('ROOT_PATH').$config['savePath'].$imgName.'/thumb/100/';
		$thumb_path = iconv('utf-8', 'gb2312',  $thumb_path);
		if(!is_dir($thumb_path))
			mkdir($thumb_path, 0777,true);
		$thumb_url = $config['savePath'].$imgName.'/thumb/100/'.$info['img']['savename'];
		$image = new \Think\Image();
		$image->open(C('ROOT_PATH').$url);
		$image->thumb(100, 100)->save('.'.$thumb_url);
		// 在子窗口中的执行JS把数据放到父窗口的表单中
		$js = '<script>';
		$js .=<<<JS
		parent.document.getElementById("logo").value='$url';
		parent.document.getElementById("pre_img").src='$thumb_url';
		parent.document.getElementById("upload").style.display="none";
		parent.document.getElementById("pre_form").reset();
		
JS;
		$js .= '</script>';
		echo $js;
	}

}
?>