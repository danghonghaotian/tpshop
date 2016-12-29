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

    protected $_validate = array(
//        array('logo', 'require', '请上传商品图片',self::EXISTS_VALIDATE,regex,self::MODEL_INSERT),
        array('goods_name', 'require', '商品名称不能为空'),
        array('goods_sn', 'require', '商品sku不能为空'),
        array('goods_number', 'require', '商品数量不能为空'),
        array('goods_number', 'require', '商品数量不能为空'),
        array('goods_number', 'number', '商品数量不合法，请输入数字'),
        array('market_price', 'require', '市场价不能为空'),
        array('market_price', 'is_num', '市场价不合法，请输入数字',self::MUST_VALIDATE,callback),
        array('shop_price', 'require', '本店价不能为空'),
        array('shop_price', 'is_num', '本店价不合法，请输入数字',self::MUST_VALIDATE,callback),
        array('weight', 'require', '商品重量不能为空'),
        array('cat_id', 'require', '请选择商品分类'),
        array('is_on_sale', 'require', '请选择商品是否上架'),
        array('no_postage', 'require', '请选择商品是否包邮'),
    );


    //添加数字校验
    public function is_num($num)
    {
        if(is_float($num) || is_numeric($num))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

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
            $config['savePath'] = '/assets/upload/tmp/';
            $upload = new \Think\Upload($config);
            //图片名称
            $imgName = current(explode('.', $_FILES['img']['name']));
            //上传生成的子目录位置
            $upload->subName =  $imgName.'/original';
            //如果已经存在该文件，先删除再重新上传，也就是同名覆盖
            $uploadFile = C('ROOT_PATH').'/assets/upload/tmp/'.$imgName.'/original/'.$_FILES['img']['name'];
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
//            这边的设计不考虑删除原图，重名的图片会被覆盖，所以这部分代码不用写
//            if(isset($this->id))
//            {
//                // 修改就删除原图
//                if(isset($_POST['old_pic']))
//                {
//                    foreach ($_POST['old_pic'] as $v)
//                    {
//                        $v = C('ROOT_PATH').$v;
//                        if(file_exists($v))
//                        {
//                            unlink($v);
//                        }
//                    }
//                }
//            }
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
        $dir =$rootPath."/assets/upload/product/{$sku}/original";
        if(!is_dir($dir))
        {
            mkdir($dir, 0777,true);
        }
        // 构造移动之后的图片的路径
        $imgName = $dir.'/'.$skuName;
        // 执行移动
        copy($rootPath.$img, $imgName);
        // 生成三张缩略图的路径，以及新图片的名称
        $thumb_dir1 = $rootPath."/assets/upload/product/{$sku}/thumb/600x";
        $thumb_dir2 = $rootPath."/assets/upload/product/{$sku}/thumb/300x";
        $thumb_dir3 = $rootPath."/assets/upload/product/{$sku}/thumb/100x";

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

    //重写商品修改
    public function save()
    {
        /*************** 1.修改会员价格的信息 ******************/
        if(isset($_POST['member_price']))
        {
            $mpModel = M('MemberPrice');
            foreach ($_POST['member_price'] as $k => $v)
            {
                // 先判断有没有这个会员价格，如果有就修改，如果没有就添加
                $level = $mpModel->where(array('goods_id'=>$this->id,'user_rank'=>$k))->count();
                $v = trim($v);
                // 如果有就修改
                if($level)
                {
                    // 如果值不为空就修改，否则删除
                    if($v)
                    {
                        $mpModel->where(array('goods_id'=>$this->id,'user_rank'=>$k))->save(array(
                            'user_price'=>$v,
                        ));
                    }
                    else
                    {
                        // 如果要修改的价格为空，就删除这个会员价格
                        $mpModel->where(array('goods_id'=>$this->id,'user_rank'=>$k))->delete();
                    }
                }
                else
                {
                    // 添加新的会员价格，如果有值就添加新的会员价格
                    if($v)
                    {
                        $mpModel->data(array(
                            'goods_id'=>$this->id,
                            'user_rank'=>$k,
                            'user_price'=>$v,
                        ))->add();
                    }
                }
            }
        }

        /*************2、修改商品属性，先删除原来的属性，再重新添加即可***************************/
        if(isset($_POST['goods_attr']))
        {
            $gaModel = M('GoodsAttr');
            $gaModel->where(array('goods_id'=>$this->id))->delete();
            foreach ($_POST['goods_attr']['attr_value'] as $k => $v)
            {
                if(is_array($v)) //单选属性
                {
                    // 如果一个属性有多个值就循环每个值，一个值一条记录
                    foreach ($v as $k1 => $v1)
                    {
                        $gaModel->data(array(
                            'goods_id'=>$this->id,
                            'attr_id'=>$k,
                            'attr_value'=>$v1,
                            'attr_price'=>$_POST['goods_attr']['attr_price'][$k][$k1],
                        ))->add();
                    }
                }
                else //唯一属性
                {
                    $gaModel->data(array(
                        'goods_id'=>$this->id,
                        'attr_id'=>$k,
                        'attr_value'=>$v,
                        'attr_price'=>0.00,
                    ))->add();
                }
            }
        }

        /*************3、修改商品相册,本系统采用图片重名覆盖原则，不删除图片服务器的图片***************************/
        if(isset($_POST['goods_gallery']) || isset($_POST['OldGoodsPic']))
        {
            $ggModel = M('GoodsGallery');
            if(isset($_POST['OldGoodsPic']))
            {
                $where['goods_id'] = $this->id;
                $where['id']  = array('not in',$_POST['OldGoodsPic']);
                $ggModel->where($where)->delete();
            }
            foreach ($_POST['goods_gallery'] as $v)
            {
                // 先把图片移动到商品目录并生成缩略图
                $arr = $this->_moveAndThumb($v);
                $ggModel->data(array(
                    'goods_id'=>$this->id,
                    'sm_logo'=>$arr[1],
                    'sm1_logo'=>$arr[2],
                    'sm2_logo'=>$arr[3],
                    'logo'=>$arr[0],
                ))->add();
            }
        }
        else //删除该商品所有相册
        {
            $ggModel = M('GoodsGallery');
            $where['goods_id'] = $this->id;
            $ggModel->where($where)->delete();
        }


        /*************** 修改基本信息放到最后，然后修改完之后TP会清空模型接收到的所有的数据 ****************/
        if(parent::save() === FALSE)
            return FALSE;
        return TRUE;
    }


    /**
     * 将百度编辑器上传的图片路径美化
     * $content = <<<EOF
     *  <img src="http://www.tpshop.com/assets/ueditor/php/../../upload/editor/2016-12/77351482974478.jpg" title="" style="width: 700px; height: 173px;" width="700" vspace="0" hspace="0" height="173" border="0">
     *  <img src="http://www.tpshop.com/assets/ueditor/php/../../upload/editor/2016-12/90691482974478.jpg" width="700">
     *  EOF;
     *  $content = preg_replace('/src=\"(.*)ueditor\/php\/..\/..\/(.*)\"/U',"src= \"/assets/$2\"", $content);
     *  echo $content;
     *
     */
    public function replaceImgUrl()
    {
        //添加
        $this->goods_desc = preg_replace('/src=\"(.*)ueditor\/php\/..\/..\/(.*)\"/U',"src= &quot;/assets/$2&quot;",$this->goods_desc);
        //修改时候，有可能双引号被转义
        $this->goods_desc = preg_replace('/src=&quot;(.*)ueditor\/php\/..\/..\/(.*)&quot;/U',"src= &quot;/assets/$2&quot;",$this->goods_desc);
    }




}