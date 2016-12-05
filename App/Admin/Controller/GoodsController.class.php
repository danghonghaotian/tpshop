<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/16
 * Time: 13:27
 */
namespace Admin\Controller;
use Think\Controller;

class GoodsController extends AdminController
{
    const RADIO = 1; //单选属性
    const UNIQUE = 0; //唯一属性

    public function lst()
    {
        $this->assign('title','商品列表');
        $this->display();
    }

    public function add()
    {
        //商品分类
        $categoryModel = D('Category');
        $categoryData = $categoryModel->select();
        $categoryData = $categoryModel ->tree($categoryData);
        $this->assign('categoryData',$categoryData);
        //商品品牌
        $brandModel = D('Brand');
        $brandData = $brandModel->order('brand_name asc')->select();
        $this->assign('brandData',$brandData);
        //会员价格
        $userRankModel =  D('UserRank');
        $userRankData =  $userRankModel->select();
        $this->assign('userRankData',$userRankData);
        //商品类型
        $goodsTypeModel = D('GoodsType');
        $goodsTypeData = $goodsTypeModel->select();
        $this->assign('goodsTypeData',$goodsTypeData);

        $this->display();
    }

    public function save()
    {
        $this->display();
    }

    public function delete()
    {

    }

    /**
     * 回收站列表
     */
    public function trashList()
    {

    }

    /**
     * 异步获取商品属性
     * @param $type_id
     */
    public function ajaxGetAttrForm($type_id)
    {
        if($type_id >0)
        {
            $AttributeModel = D('Attribute');
            $attributeData = $AttributeModel->where(array('goods_type_id'=>$type_id))->select();
           foreach ($attributeData as $k=>$v)
           {
               if($v['attr_type'] == self::RADIO) //单选属性
               {
                   $attrValue = explode(',',$v['attr_value']);
                   $str = '';
                   $str .="<tr><td class='label'><a onclick='addANewAttRow(this)' href='javascript:void(0);'>[+]</a>{$v['attr_name']}</td><td><select name='attr_value[]' style='width: 120px;'>";
                   foreach ($attrValue as $v1)
                   {
                       $str .= "<option value=''>$v1</option>";
                   }
                   $str .="</select> 属性价格<input type='text'name='' size='6' /></td></tr>";
                   echo $str;
               }
               if($v['attr_type'] == self::UNIQUE)//唯一属性
               {
                   if(empty($v['attr_value']))
                   {
                       echo "<tr><td class='label'>{$v['attr_name']}</td><td><input type='text' name='attr_value[]' value=''/></td>";
                   }
                   else
                   {
                       $attrValue = explode(',',$v['attr_value']);
                       $str = '';
                       $str .="<tr><td class='label'>{$v['attr_name']}</td><td><select name='attr_value[]'>";
                       foreach ($attrValue as $v1)
                       {
                           $str .= "<option value=''>$v1</option>";
                       }
                       $str .="</select></td></tr>";
                       echo $str;
                   }
               }
           }
        }
        else
        {
            echo 'error';
        }
    }

    /**
     * 上传单张图片
     */
    public function ajaxUpload()
    {
        header('content-type:text/html;charset=utf-8');
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
//        echo $thumb_path;die;
        if(!is_dir($thumb_path))
            mkdir($thumb_path, 0777,true);
        $thumb_url = $config['savePath'].$imgName.'/thumb/100/'.$info['img']['savename'];
//        $thumb_url = iconv('utf-8', 'gb2312', $thumb_url);
        $image = new \Think\Image();
        $image->open($url);
        $image->thumb(100, 100)->save($thumb_url);
//        die;
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

    /**
     * 批量上传图片商品图片相册
     */
    public function ajaxBUpload()
    {
        // 读取上传图片的配置
        $config = C('UPLOAD_CONFIG');
        // 设置上传路径
        $config['savePath'] = './assets/admin/tmp/';
        $upload = new \Think\Upload($config);
        //图片名称
        $imgName = current(explode('.', $_FILES['img']['name']));
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
        $image->open($url);
        $image->thumb(100, 100)->save($thumb_url);
//        die;
        // 在子窗口中的执行JS把数据放到父窗口的表单中
        $js = '<script>';
        $img = "<li><input type='hidden' name='GoodsPic[]' value='$url' /><img src='/$thumb_url' /><br /><a onclick='this.parentNode.parentNode.removeChild(this.parentNode);' href='javascript:void(0);'>[-]</a></li>";
        $js .=<<<JS
		parent.document.getElementById("bpre_img").innerHTML += "$img";
		parent.document.getElementById("bupload").style.display="none";
		parent.document.getElementById("bpre_form").reset();
JS;
        $js .= '</script>';
        echo $js;
    }
}