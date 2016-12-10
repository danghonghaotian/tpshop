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
        //插入商品基本信息goods表
        if(($goods_id = parent::add()) === FALSE)
        {
           return false;
        }

        //插入会员价格信息member_price表
        if(isset($_POST['member_price']))
        {
            $memberPriceModel = M('MemberPrice');
            foreach ($_POST['member_price'] as $k => $v)
            {
                $v = trim($v);
                if(!$v)
                {
                    continue ;  //没有会员价格跳过不插入记录
                }
               $memberPriceModel->data(array(
                    'goods_id'=>$goods_id,
                    'user_rank'=>$k,
                    'user_price'=>$v,
                ))->add();
            }
        }

        //添加数据到商品属性表goods_attr
        if(isset($_POST['goods_attr']))
        {
            $gaModel = M('GoodsAttr');
            foreach ($_POST['goods_attr']['attr_value'] as $k => $v)
            {
                if(is_array($v)) //单选属性
                {
                    // 如果一个属性有多个值就循环每个值，一个值一条记录
                    foreach ($v as $k1 => $v1)
                    {
                       $gaModel->data(array(
                            'goods_id'=>$goods_id,
                            'attr_id'=>$k,
                            'attr_value'=>$v1,
                            'attr_price'=>$_POST['goods_attr']['attr_price'][$k][$k1],
                        ))->add();
                    }
                }
                else //唯一属性
                {
                    $gaModel->data(array(
                        'goods_id'=>$goods_id,
                        'attr_id'=>$k,
                        'attr_value'=>$v,
                        'attr_price'=>0.00,
                    ))->add();
                }
            }
        }

        //添加商品相册中的数据 goods_gallery表
        if(isset($_POST['goods_gallery']))
        {
            $gpModel = M('GoodsGallery');
            foreach ($_POST['goods_gallery'] as $v)
            {
                // 先把图片移动到商品目录并生成缩略图
                $arr = $this->_moveAndThumb($v);
                $gpModel->data(array(
                    'goods_id'=>$goods_id,
                    'sm_logo'=>$arr[1],
                    'sm1_logo'=>$arr[2],
                    'sm2_logo'=>$arr[3],
                    'logo'=>$arr[0],
                ))->add();
            }
        }
        return $goods_id;

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
     * @param int $is_delete 0正常商品 1回收站商品
     * @return array
     */
    public function search($keyword ='',$is_delete=0)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = "is_delete = $is_delete";
        $where .= " and (goods_name like '%$keyword%' or goods_sn like '%$keyword%')";
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个商品';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->order('id desc')->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }


    /**
     * 判断一件商品是否有单选属性，如果有的话，可以设置商品货号
     * @param $goods_id
     * @return bool
     */
    public function haveRadioType($goods_id)
    {
        $goodsAttrModel = M('GoodsAttr');
        $gaArr = $goodsAttrModel->where(array('goods_id'=>$goods_id))->field('attr_id')->group('attr_id')->select();
        $data = array();
        foreach ($gaArr as $k=>$v)
        {
            foreach ($v as $v1)
            {
                $data[$k] = $v1;
            }
        }
        $attributeModel = M('Attribute');
        $attrData = $attributeModel->where(array('id'=>array('in',$data)))->field('attr_type')->group('attr_type')->select();

        if(in_array(array('attr_type'=>1), $attrData))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * 获取商品的单选属性数据
     * @param $id
     * @return array
     */
    public function getGoodsAttrRadioData($id)
    {
        $sql = 'SELECT a.id,a.goods_id,a.attr_id,a.attr_value,a.attr_price,b.attr_name,b.attr_type,b.goods_type_id from tp_goods_attr as a LEFT JOIN tp_attribute as b on  a.attr_id = b.id WHERE goods_id ='.$id.' and attr_type = 1';
        $attr =  M()->query($sql);
        $data = array();
        foreach ($attr as $k=>$v)
        {
            $data[$v['attr_name']][] = array($v['attr_id'],$v['attr_value']);
        }
        return $data;
    }




}