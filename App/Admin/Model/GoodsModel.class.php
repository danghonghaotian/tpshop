<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/11/30
 * Time: 15:33
 */
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model
{

    /**
     * 上传商品图片到临时目录
     * 使用同名覆盖原则
     * @return bool|string
     */
    public function uploadImgToTmpDir()
    {
        // 判断有没有上传图片
        if($_FILES['img']['tmp_name'])
        {
            /**************** 上传原图片 ***********************/
            // 读取上传图片的配置
            $config = C('UPLOAD_CONFIG');
            // 设置上传路径
            $config['savePath'] = '/assets/admin/tmp/';
            $upload = new \Think\Upload($config);
            //图片名称
            $imgName = current(explode('.', $_FILES['img']['name']));
            //上传生成的子目录位置
            $upload->subName =  $imgName.'/original';
            //如果已经存在该文件，先删除再重新上传，也就是同名覆盖
            $uploadFile = C('ROOT_PATH').'/assets/admin/tmp/'.$imgName.'/original/'.$_FILES['img']['name'];
            if(file_exists($uploadFile))
            {
                unlink($uploadFile);
            }
            // 执行上传
            $info = $upload->upload();
            if(!$info)
            {
                $msg = $upload->getError();
                return $msg;  //返回错误信息
            }
            /***************** 生成缩略图 ************************/
            $image = new \Think\Image();
            // 缩略图保存地址
            $thumb_path = C('ROOT_PATH').$config['savePath'].$imgName.'/thumb/100/';
            $thumb_path2 = C('ROOT_PATH').$config['savePath'].$imgName.'/thumb/300/';
            $thumb_path3 = C('ROOT_PATH').$config['savePath'].$imgName.'/thumb/600/';
            // 缩略图完整的名字
            $thumb_name = $thumb_path.$info['img']['savename'];
            $thumb_name2 = $thumb_path2.$info['img']['savename'];
            $thumb_name3 = $thumb_path3.$info['img']['savename'];
            if(!is_dir($thumb_path))
                mkdir($thumb_path, 0777,true);
            if(!is_dir($thumb_path2))
                mkdir($thumb_path2, 0777,true);
            if(!is_dir($thumb_path3))
                mkdir($thumb_path3, 0777,true);
            // 打开原图
            $image->open(C('ROOT_PATH').$info['img']['savepath'].$info['img']['savename']);  //需要物理路径
            // 生成缩略图
            $image->thumb(600, 600)->save($thumb_name3);
            $image->thumb(300, 300)->save($thumb_name2);
            $image->thumb(100, 100)->save($thumb_name);
            return true;
        }
        else
        {
            $msg = '商品图片还没上传,检查原因，图片大小不能大于2M!!';
            return $msg;
        }
    }

    /**
     * 清除指定目录的所有文件
     * @param  [string] $dir 要清除的目录名
     * @return  void   没有返回值
     */
    public function clearPic($dir)
    {
        $dh=opendir($dir);
        while (!!$file = readdir($dh))
        {
            if($file!="." && $file!="..")
            {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath))
                {
                    unlink($fullpath);   //删除不是目录的文件，如tmp/20141231142112.JPG
                }
                else
                {
                    $this->clearPic($fullpath);  //递归删除子目录下的文件，$fullpath=tmp/1
                    rmdir($fullpath);  //删除空目录
                }
            }
        }
        closedir($dh);
    }

    /**
     * 添加商品
     * 商品基本信息
     * 商品会员价格信息
     * 商品属性信息
     * 商品相册信息
     */
    public function add()
    {
        if(($goods_id = parent::add()) === FALSE)
        {
           return false;
        }
    }

    /**
     * 上传图片
     * 新添加的图片或者修改时都用到
     */
    public function upload()
    {
        // 如果上传了图片，并且图片是在临时目录中的（说明是新上传的）那么就修改
        if($this->logo && strpos($this->logo, 'tmp') !== FALSE)
        {
            // 判断是修改商品就先删除原图： 所有修改的表单中都会有一个id的隐藏域
            if(isset($this->id))
            {
                // 修改就删除原图
                if(isset($_POST['old_pic']))
                {
                    foreach ($_POST['old_pic'] as $v)
                    {
                        $v = C('ROOT_PATH').$v;
                        if(file_exists($v))
                        {
                            unlink($v);
                        }
                    }
                }
            }
            // 移动原图并生成缩略图
            $arr = $this->_moveAndThumb($this->logo);
            // 把图片的地址赋给模型
            $this->logo = $arr[0];
            $this->sm_logo = $arr[1];
            $this->sm1_logo = $arr[2];
            $this->sm2_logo = $arr[3];
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
        $skuName = substr(strrchr($img, '/'),1);

        //图片存储目录算法,取出sku
        if(count(explode('_',$skuName)) == 1)
        {
            $sku = current(explode('.',$skuName));
        }
        else
        {
            $sku = current(explode('_',$skuName));
        }
        //优化代码
        $rootPath = C('ROOT_PATH');
        // 构造图片存放目录的路径
        $dir =$rootPath."/assets/admin/product/{$sku}/original";
        if(!is_dir($dir))
        {
            mkdir($dir, 0777,true);
        }
        // 构造移动之后的图片的路径
        $imgName = $dir.'/'.$skuName;
        // 执行移动
        copy($rootPath.$img, $imgName);
        // 生成三张缩略图的路径，以及新图片的名称
        $thumb_dir1 = $rootPath."/assets/admin/product/{$sku}/thumb/600x";
        $thumb_dir2 = $rootPath."/assets/admin/product/{$sku}/thumb/300x";
        $thumb_dir3 = $rootPath."/assets/admin/product/{$sku}/thumb/100x";

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
        $img1 = $thumb_dir1.'/'.$skuName;
        $img2 = $thumb_dir2.'/'.$skuName;
        $img3 = $thumb_dir3.'/'.$skuName;
        $image = new \Think\Image();
        $image->open($imgName);
        $image->thumb(600, 600)->save($img3);
        $image->thumb(300, 300)->save($img2);
        $image->thumb(100, 100)->save($img1);

        //不要带硬盘路径的图片
        $imgName = substr($imgName,strlen($rootPath));
        $img1 = substr($img1,strlen($rootPath));
        $img2 = substr($img2,strlen($rootPath));
        $img3 = substr($img3,strlen($rootPath));

        $imgArr =  array(
            $imgName,
            $img1,
            $img2,
            $img3,
        );

        return $imgArr;
    }





}