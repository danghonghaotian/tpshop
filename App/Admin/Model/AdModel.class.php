<?php
/**
 * 广告模型
 * User: 钟贵廷
 * Date: 2016/12/13
 * Time: 20:27
 */

namespace Admin\Model;
use Think\Model;
class AdModel extends Model
{


    protected $_validate = array(
        array('ad_name',"require","广告名称必须!"),
        array('ad_img',"require","广告图片必须!"),
        array('ad_id',"require","请选择发布的位置"),
        array('start_time',"require","开始时间必须!"),
        array('end_time',"require","结束时间必须"),
        array('ad_url',"require","广告链接必须"),
    );
    /**
     * 搜索
     * @return array
     */
    public function search($keyword)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        $where .= " and (ad_name like '%$keyword%')";
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个广告';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->order("id desc")->select();
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
        if($this->ad_img && strpos($this->ad_img, 'tmp') !== FALSE)
        {
           if(isset($_POST['ad_size']) && !empty($_POST['ad_size']))
           {
               if(isset($this->id))
               {
                   // 修改就删除原图
                   if(isset($_POST['old_ad_img']))
                   {
                       foreach ($_POST['old_ad_img'] as $v)
                       {
                           $v = C('ROOT_PATH').$v;
                           if(file_exists($v))
                           {
                               unlink($v);
                           }
                       }
                   }
               }

               list($width,$height) = explode(',',$_POST['ad_size']);
               //优化代码
               $rootPath = C('ROOT_PATH');
               // 构造图片存放目录的路径
               $date = date('Y-m',time());
               //目录结构宽高/年月组成
               $dir =$rootPath."/assets/upload/ad/{$width}x{$height}/$date";
               if(!is_dir($dir))
               {
                   mkdir($dir, 0777,true);
               }

               $adName = time().'.'.end(explode('.',$this->ad_img));
               $imgName = $dir.'/'. $adName; //原图
               $sm1_logo = $dir.'/sm1_'. $adName;  //100
               $sm2_logo = $dir.'/sm2_'. $adName;  //真正的广告图
               copy($rootPath.$this->ad_img,$imgName);
               $image = new \Think\Image();
               $image->open($imgName);

               $image->thumb($width, $height)->save($sm2_logo);
               $image->thumb(100, 100*$height/$width)->save($sm1_logo);

               $this->ad_img = substr($imgName,strlen($rootPath));
               $this->sm2_logo = substr($sm2_logo,strlen($rootPath));
               $this->sm1_logo = substr($sm1_logo,strlen($rootPath));

           }
        }
    }



}