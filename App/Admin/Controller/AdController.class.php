<?php
/**
 * 广告控制器
 * User: 钟贵廷
 * Date: 2016/12/13
 * Time: 20:26
 */

namespace Admin\Controller;
use Think\Controller;

class AdController extends AdminController
{
    public function lst($keyword = '')
    {
        $adPositionModel =  D('Ad');
        $data = $adPositionModel -> search(trim($keyword));
        $this->assign('ad', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

    public function add()
    {

        $adPositionModel = D('AdPosition');
        $adPosition = $adPositionModel->select();
        $this->assign('adPosition',$adPosition);
        $this->display();
    }

    public function save($id)
    {

    }

    public function delete($id)
    {

    }

    /**
     * 上传单张图片
     */
    public function ajaxUpload()
    {
        // 读取上传图片的配置
        $config = C('UPLOAD_CONFIG');
        // 设置上传路径
        $config['savePath'] = '/assets/admin/tmp/';
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