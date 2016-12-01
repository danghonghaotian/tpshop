<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/26
 * Time: 15:56
 */
namespace Admin\Model;
use Admin\Controller\BrandController;
use Think\Model;
use Think\Think;

class BrandModel extends Model
{
    protected $_validate = array(
        array('brand_name', 'require', '品牌名称不能为空'),
        array('site_url', 'require', '官网网址不能为空'),
    );

    /**
     * 搜索
     * @return array
     */
    public function search()
    {
        $where = 1;
        $count = $this->where($where)->count();
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个品牌';
        $pageStr = $page->fpage();
        $data = $this->where($where)->limit( $page->limit)->order("brand_id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }

    /**
     * 是否显示
     * @return array
     */
    public function getShow()
    {
        $arr = array();
        $arr['0'] = '否';
        $arr['1'] = '是';
        return $arr;
    }

    public function upload()
    {
        // 判断有没有上传图片
        if($_FILES['brand_logo']['tmp_name'])
        {
            /**************** 上传原图片 ***********************/
            // 读取上传图片的配置
            $config = C('UPLOAD_CONFIG');
            // 设置上传路径
            $config['savePath'] = '/assets/admin/brand/';
            $upload = new \Think\Upload($config);
            //品牌名称
            $brandName = current(explode('.', $_FILES['brand_logo']['name']));
            //上传生成的子目录位置
            $upload->subName =  $brandName.'/original';
            //如果已经存在该文件，先删除再重新上传，也就是同名覆盖
            $uploadFile = C('ROOT_PATH').'/assets/admin/brand/'.$brandName.'/original/'.$_FILES['brand_logo']['name'];
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
            // 设置模型原图地址
            $this->brand_logo = $info['brand_logo']['savepath'].$info['brand_logo']['savename'];
            /***************** 生成缩略图 ************************/
            $image = new \Think\Image();
            // 缩略图保存地址
            $thumb_path = C('ROOT_PATH').$config['savePath'].$brandName.'/thumb/100/';
            // 缩略图完整的名字
            $thumb_name = $thumb_path.$info['brand_logo']['savename'];
            if(!is_dir($thumb_path))
                mkdir($thumb_path, 0777,true);
            // 打开原图
            $image->open(C('ROOT_PATH').$this->brand_logo);  //需要物理路径
            // 生成缩略图
            $image->thumb(100, 100)->save($thumb_name);
            //存入数据库
            $this->brand_thumb = $config['savePath'].$brandName.'/thumb/100/'.$info['brand_logo']['savename'];
            return true;
        }
        else
        {
             $msg = '品牌图片还没上传,检查原因，图片大小不能大于2M!!';
             return $msg;
        }
    }


    /**
     * 返回品牌路径
     * @param $imgName
     * @return string
     */
    public function getImgPath($imgName)
    {
        $img = current(explode('.',$imgName));
        return '/assets/brand/admin/'.$img.'/thumb/100/'.$imgName;
    }



}