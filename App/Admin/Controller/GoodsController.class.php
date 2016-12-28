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

    public function lst($keyword = '')
    {
        $this->assign('title','商品列表');
        $goodsModel = D('Goods');
        $data = $goodsModel->search(trim($keyword));
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $goodsModel = D('goods');
            if($goodsModel->create($_POST['goods']))
            {
                //上传图片
                $goodsModel->upload();
                // 插入数据库
                if(($goods_id=$goodsModel->add()) !== FALSE)
                {
                    $this->success('添加成功', U('lst'));
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                    {
                        echo 'SQL为：'.$goodsModel->getLastSql().' - ERROR:'.mysql_error();
                    }
                    else
                    {
                        $this->error('发生失败，请重试！');
                    }
                }
            }
            else
            {
                $this->error($goodsModel->getError());  // 输出表单验证失败的原因
            }
        }
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

    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Goods');
            if($model->create($_POST['goods']))
            {
                //需要重新赋值模型id
                $model->id =$id;
                // 上传图片
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
        //商品基本信息
        $goodsModel = D('Goods');
        $goods = $goodsModel->find($id);
        $this->assign('goods',$goods);
        //商品分类
        $categoryModel = D('Category');
        $categoryData = $categoryModel->select();
        $categoryData = $categoryModel ->tree($categoryData);
        $this->assign('categoryData',$categoryData);
        //商品品牌
        $brandModel = D('Brand');
        $brandData = $brandModel->order('brand_name asc')->select();
        $this->assign('brandData',$brandData);
        //会员等级
        $userRankModel =  D('UserRank');
        $userRankData =  $userRankModel->select();
        $this->assign('userRankData',$userRankData);
        // 取出这件商品的会员价格的数据
        $mp = D('MemberPrice');
        $_mpData = $mp->where('goods_id='.$id)->select();
        $mpData = array();
        // 处理一下会员价格的数组
        foreach ($_mpData as $v)
        {
            $mpData[$v['user_rank']] = $v['user_price'];
        }
        $this->assign('mpData', $mpData);
        //商品类型
        $goodsTypeModel = D('GoodsType');
        $goodsTypeData = $goodsTypeModel->select();
        $this->assign('goodsTypeData',$goodsTypeData);

        // 取出这件商品所有的图片
        $ggModel = M('GoodsGallery');
        $gpData = $ggModel->where(array('goods_id'=>$id))->select();
        $this->assign('gpData', $gpData);

        $this->display();
    }

    /**
     * 商品回收
     * @param $id
     */
    public function trash($id)
    {
        $goodsModel = M('Goods');
        $goodsModel->where(array('id'=>$id))->setField('is_delete',1);
        $this->success("已放到商品回收站");
    }

    /**
     * 批量放到回收站
     */
    public function batchTrash()
    {
        if(I('post.goods_id'))
        {
            $idArr =  I('post.goods_id');
            $ids = implode(',',$idArr );
            $goodsModel = M("Goods");
            $goodsModel->where(array('id'=>array('in',$ids)))->save(array('is_delete'=>1));
            $this->success("批量回收成功！");
        }
    }


    /**
     * 删除单条商品
     * @param $id
     */
    public function delete($id)
    {
        $goodsModel = M("Goods");
        $goodsModel->delete($id);
        $this->success('删除成功!');
    }


    /**
     * 商品批量删除
     */
    public function batchDel()
    {
        $goodsModel = M("Goods");
        if(I('post.goods_id'))
        {
            $idArr = I('post.goods_id');
            $ids = implode(',',$idArr);
            $goodsModel->delete($ids);
            $this->success('批量删除成功！');
        }
    }

    /**
     * 回收站列表
     */
    public function trashList($keyword = '')
    {
        $this->assign('title','商品回收站');
        $goodsModel = D('Goods');
        $data = $goodsModel->search(trim($keyword),1);
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

    /**
     * 恢复删除的商品
     * @param $id
     */
    public function recovery($id)
    {
        $goodsModel = M('Goods');
        $goodsModel->where(array('id'=>$id))->setField('is_delete',0);
        $this->success("商品已恢复");
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
                   $str .="<tr><td class='label'><a onclick='addANewAttRow(this)' href='javascript:void(0);'>[+]</a>{$v['attr_name']}</td><td><select name='goods_attr[attr_value][{$v['id']}][]' style='width: 120px;'>";
                   foreach ($attrValue as $v1)
                   {
                       $str .= "<option value='".$v1."'>$v1</option>";
                   }
                   $str .="</select> 属性价格<input type='text'name='goods_attr[attr_price][{$v['id']}][]' size='6' /></td></tr>";
                   echo $str;
               }
               if($v['attr_type'] == self::UNIQUE)//唯一属性
               {
                   if(empty($v['attr_value']))
                   {
                       echo "<tr><td class='label'>{$v['attr_name']}</td><td><input type='text' name='goods_attr[attr_value][{$v['id']}]' value=''/></td>";
                   }
                   else
                   {
                       $attrValue = explode(',',$v['attr_value']);
                       $str = '';
                       $str .="<tr><td class='label'>{$v['attr_name']}</td><td><select name='goods_attr[attr_value][{$v['id']}]'>";
                       foreach ($attrValue as $v1)
                       {
                           $str .= "<option value='".$v1."'>$v1</option>";
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

    /**
     * 批量上传图片商品图片相册
     */
    public function ajaxBUpload()
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
        $img = "<li><input type='hidden' name='goods_gallery[]' value='$url' /><img src='$thumb_url' /><br /><a onclick='this.parentNode.parentNode.removeChild(this.parentNode);' href='javascript:void(0);'>[-]</a></li>";
        $js .=<<<JS
		parent.document.getElementById("bpre_img").innerHTML += "$img";
		parent.document.getElementById("bupload").style.display="none";
		parent.document.getElementById("bpre_form").reset();
JS;
        $js .= '</script>';
        echo $js;
    }

    /**
     * 商品货号列表
     * @param $id
     */
    public function productList($id)
    {

        echo '商品货号';
    }


    /**
     * 清理服务器上传的临时缓存图片
     */
    public function clearPic()
    {
        $goodsModel = D('Goods');
        $dir = C('ROOT_PATH').'/assets/upload/tmp';
        $goodsModel->clearPic($dir);
        $this->success('清理服务器上传的临时缓存图片成功',U('Admin/Index/main'));
    }


}