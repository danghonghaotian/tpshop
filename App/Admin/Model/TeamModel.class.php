<?php
/**
 * 团队模型
*/
namespace Admin\Model;
use Think\Model;
class TeamModel extends Model
{
	protected $_validate = array(
		array('cat_id', 'require', '请选择一个分类'),
		array('username', 'require', '职员名称不能为空'),
	);


	/**
	 * 搜索
	 * @return array
	 */
	public function search($keyword,$is_delete=1)
	{
		// 搜索所有的数据,如果需要搜索其他字段需要自己添加
		$where = 1;
		$where .= " and is_delete = $is_delete and (username like '%$keyword%')";
		/** 翻页 **********/
		//1 . 算出总的记录数
		$count = $this->where($where)->count();
		// 2. 生成翻页类的对象
		$page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
		$page->config['header'] = '个成员';
		// 3. 生成翻页的字符串：上一页、下一页
		$pageStr = $page->fpage();
		// 4. 取出当前页的数据
		$data = $this->where($where)->limit( $page->limit)->order("cat_id desc,id desc")->select();
		return array(
			'page' => $pageStr,
			'data' => $data,
		);
	}


	/**
	 * 上传图片
	 */
	public function upload()
	{
		// 如果上传了图片，并且图片是在临时目录中的（说明是新上传的）
		if($this->original && strpos($this->original, 'tmp') !== FALSE)
		{
			$newPic = $this->original;
			if(isset($this->id))
            {
                // 修改就删除之前上传过的原图
				$id = $this->id;
				$data = $this->find($id);
				if(file_exists(C('ROOT_PATH').$data['original']))
				{
					unlink(C('ROOT_PATH').$data['original']);
				}
				if(file_exists(C('ROOT_PATH').$data['thumb1']))
				{
					unlink(C('ROOT_PATH').$data['thumb1']);
				}
				if(file_exists(C('ROOT_PATH').$data['thumb2']))
				{
					unlink(C('ROOT_PATH').$data['thumb2']);
				}
				if(file_exists(C('ROOT_PATH').$data['thumb3']))
				{
					unlink(C('ROOT_PATH').$data['thumb3']);
				}
            }

			// 移动原图并生成缩略图
			$arr = $this->_moveAndThumb($newPic);
			// 把图片的地址赋给模型
			$this->original= $arr[0];
			$this->thumb1 = $arr[1];
			$this->thumb2 = $arr[2];
			$this->thumb3 = $arr[3];
		}
	}


	/**
	 * 把图片移动并生成缩略图
	 * @param $img
	 * @return array
	 */
	private function _moveAndThumb($img)
	{
		// 从图片路径中取出图片的名称
		$userName = substr(strrchr($img, '/'),1);

		//图片存储目录算法,取出user_name
		if(count(explode('_',$userName)) == 1)
		{
			$user_name = current(explode('.',$userName));
		}
		else
		{
			$user_name = current(explode('_',$userName));
		}
		//优化代码
		$rootPath = C('ROOT_PATH');
		// 构造图片存放目录的路径
		$dir =$rootPath."/assets/upload/team/{$user_name}/original";
		if(!is_dir($dir))
		{
			mkdir($dir, 0777,true);
		}
		// 构造移动之后的图片的路径
		$imgName = $dir.'/'.$userName;
		// 执行移动
		copy($rootPath.$img, $imgName);
		// 生成三张缩略图的路径，以及新图片的名称
		$thumb_dir1 = $rootPath."/assets/upload/team/{$user_name}/thumb/600x";
		$thumb_dir2 = $rootPath."/assets/upload/team/{$user_name}/thumb/300x";
		$thumb_dir3 = $rootPath."/assets/upload/team/{$user_name}/thumb/100x";

		if(!is_dir($thumb_dir1))
		{
			mkdir($thumb_dir1, 0777,true);
		}
		if(!is_dir($thumb_dir2))
		{
			mkdir($thumb_dir2, 0777,true);
		}
		if(!is_dir($thumb_dir3))
		{
			mkdir($thumb_dir3, 0777,true);
		}
		$img1 = $thumb_dir1.'/'.$userName;
		$img2 = $thumb_dir2.'/'.$userName;
		$img3 = $thumb_dir3.'/'.$userName;
		$image = new \Think\Image();
		$image->open($imgName);
		$image->thumb(600, 600)->save($img1);
		$image->thumb(300, 300)->save($img2);
		$image->thumb(100, 100)->save($img3);

		//不要带硬盘路径的图片
		$imgName = substr($imgName,strlen($rootPath));
		$img1 = substr($img1,strlen($rootPath));
		$img2 = substr($img2,strlen($rootPath));
		$img3 = substr($img3,strlen($rootPath));

		$imgArr =  array(
			$imgName,
			$img3, //100x
			$img2, //300x
			$img1, //600x
		);

		return $imgArr;
	}


	/**
	 * 删除成员，应该把成员图片也删除
	 * @param array|mixed $id
	 * @return mixed
	 */
	public function delete($id)
	{
		$data = $this->find($id);
		if(file_exists(C('ROOT_PATH').$data['original']))
		{
			unlink(C('ROOT_PATH').$data['original']);
		}
		if(file_exists(C('ROOT_PATH').$data['thumb1']))
		{
			unlink(C('ROOT_PATH').$data['thumb1']);
		}
		if(file_exists(C('ROOT_PATH').$data['thumb2']))
		{
			unlink(C('ROOT_PATH').$data['thumb2']);
		}
		if(file_exists(C('ROOT_PATH').$data['thumb3']))
		{
			unlink(C('ROOT_PATH').$data['thumb3']);
		}

		return parent::delete($id);
	}


}
?>