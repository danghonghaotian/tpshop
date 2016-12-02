<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/11/30
 * Time: 15:33
 */
namespace Admin\Model;
use Think\Model;
use Think\Think;

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
}