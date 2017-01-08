<?php
/**
 * 图片处理类
 * User: 钟贵廷
 * Date: 2017/1/8
 * Time: 12:42
 */

namespace Home\Component;

class ImageTool
{
    /* 水印相关常量定义 */
    const IMAGE_WATER_NORTHWEST =   1 ; //常量，标识左上角水印
    const IMAGE_WATER_NORTH     =   2 ; //常量，标识上居中水印
    const IMAGE_WATER_NORTHEAST =   3 ; //常量，标识右上角水印
    const IMAGE_WATER_WEST      =   4 ; //常量，标识左居中水印
    const IMAGE_WATER_CENTER    =   5 ; //常量，标识居中水印
    const IMAGE_WATER_EAST      =   6 ; //常量，标识右居中水印
    const IMAGE_WATER_SOUTHWEST =   7 ; //常量，标识左下角水印
    const IMAGE_WATER_SOUTH     =   8 ; //常量，标识下居中水印
    const IMAGE_WATER_SOUTHEAST =   9 ; //常量，标识右下角水印

    /**
     * 获取图片信息
     * @param $image
     * @return array|bool
     */
    private static function getImageInfo($image)
    {
        if(!file_exists($image)) //图片是否存在
        {
            return false;
        }

        $info = getimagesize($image);

        if($info == false) //如果不是图片
        {
            return false;
        }

        $img = array();
        $img['width'] = $info[0];
        $img['height'] = $info[1];
        $img['ext'] = image_type_to_extension($info[2], false);  //图片后缀

        return $img;
    }


    /**
     * 添加水印
     * @param $dst 需要添加水印的图片
     * @param $water  水印图
     * @param null $save 保存位置，默认替换
     * @param int $locate 水印加在哪里
     * @param int $alpha 透明度
     * @return bool
     */
    public static function water($dst,$water,$save=null,$locate = self::IMAGE_WATER_SOUTHEAST,$alpha=80)
    {
        //资源检测
        if(!is_file($dst) || !is_file($water))
        {
            return false;
        }

        $dst_info = self::getImageInfo($dst);
        $water_info = self::getImageInfo($water);
        
        //判断是否图片
        if($dst_info == false || $water_info == false)
        {
            return false;
        }

        //水印图不能比原图大
        if(($water_info['height']>$dst_info['height']) || ($water_info['width']>$dst_info['width']))
        {
            return false;
        }


        $dst_fun   = 'imagecreatefrom' . $dst_info['ext'];
        $water_fun   = 'imagecreatefrom' . $water_info['ext'];

        if(!function_exists($dst_fun) || !function_exists($water_fun))
        {
            return false;
        }
        //创建对应的图像画布资源
        $new_dst = $dst_fun($dst);
        $new_water = $water_fun($water);



        //设定水印图像的混色模式
        imagealphablending($new_water, true);

        /* 设定水印位置 */
        switch ($locate) {
            /* 右下角水印 */
            case self::IMAGE_WATER_SOUTHEAST:
                $x = $dst_info['width'] - $water_info['width'];
                $y = $dst_info['height'] - $water_info['height'];
                break;

            /* 左下角水印 */
            case self::IMAGE_WATER_SOUTHWEST:
                $x = 0;
                $y = $dst_info['height'] - $water_info['height'];
                break;

            /* 左上角水印 */
            case self::IMAGE_WATER_NORTHWEST:
                $x = $y = 0;
                break;

            /* 右上角水印 */
            case self::IMAGE_WATER_NORTHEAST:
                $x = $dst_info['width'] - $water_info['width'];
                $y = 0;
                break;

            /* 居中水印 */
            case self::IMAGE_WATER_CENTER:
                $x = ($dst_info['width'] - $water_info['width'])/2;
                $y = ($dst_info['height'] - $water_info['height'])/2;
                break;

            /* 下居中水印 */
            case self::IMAGE_WATER_SOUTH:
                $x = ($dst_info['width'] - $water_info['width'])/2;
                $y = $dst_info['height'] - $water_info['height'];
                break;

            /* 右居中水印 */
            case self::IMAGE_WATER_EAST:
                $x = $dst_info['width'] - $water_info['width'];
                $y = ($dst_info['height'] - $water_info['height'])/2;
                break;

            /* 上居中水印 */
            case self::IMAGE_WATER_NORTH:
                $x = ($dst_info['width'] - $water_info['width'])/2;
                $y = 0;
                break;

            /* 左居中水印 */
            case self::IMAGE_WATER_WEST:
                $x = 0;
                $y = ($dst_info['height'] - $water_info['height'])/2;
                break;

            default:
                /* 自定义水印坐标 */
                if(is_array($locate)){
                    list($x, $y) = $locate;
                } else {
                    die('不支持的水印位置类型');
                }
        }

        //添加水印
        imagecopymerge($new_dst, $new_water, $x, $y, 0, 0, $water_info['width'], $water_info['height'], $alpha);

        if(!$save)
        {
            $save = $dst;
            unlink($dst);
        }

        //动态保存图片
        $createFunc = 'image'.$dst_info['ext'];
        $createFunc($new_dst,$save);

        //销毁图片资源
        imagedestroy($new_dst);
        imagedestroy($new_water);

        return true;

    }


    /**
     *  thumb 生成缩略图，等比例缩放,两边留白
     * @param $dst
     * @param null $save
     * @param int $width
     * @param int $height
     * @return bool
     */
    public static function thumb($dst,$save=NULL,$width=200,$height=200)
    {
        // 首先判断待处理的图片存不存在
        $dinfo = self::getImageInfo($dst);
        if($dinfo == false)
        {
            return false;
        }

        // 计算缩放比例
        $calc = min($width/$dinfo['width'], $height/$dinfo['height']);

        // 创建原始图的画布
        $dfunc = 'imagecreatefrom' . $dinfo['ext'];
        $dim = $dfunc($dst);

        // 创建缩略画布
        $tim = imagecreatetruecolor($width,$height);

        // 创建白色填充缩略画布
        $white = imagecolorallocate($tim,255,255,255);

        // 填充缩略画布
        imagefill($tim,0,0,$white);

        // 复制并缩略
        $dwidth = (int)$dinfo['width']*$calc;
        $dheight = (int)$dinfo['height']*$calc;

        $paddingx = (int)($width - $dwidth) / 2;
        $paddingy = (int)($height - $dheight) / 2;


        imagecopyresampled($tim,$dim,$paddingx,$paddingy,0,0,$dwidth,$dheight,$dinfo['width'],$dinfo['height']);

        // 保存图片
        if(!$save)
        {
            $save = $dst;
            unlink($dst);
        }

        $createfunc = 'image' . $dinfo['ext'];
        $createfunc($tim,$save);

        imagedestroy($dim);
        imagedestroy($tim);

        return true;

    }


    /**
     * 验证码
     * @param int $width
     * @param int $height
     */
    public static function captcha($width=50,$height=25)
    {
        //造画布
        $image = imagecreatetruecolor($width,$height) ;

        //造背影色
        $gray = imagecolorallocate($image, 200, 200, 200);

        //填充背景
        imagefill($image, 0, 0, $gray);

        //造随机字体颜色
        $color = imagecolorallocate($image, mt_rand(0, 125), mt_rand(0, 125), mt_rand(0, 125)) ;
        //造随机线条颜色
        $color1 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
        $color2 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));
        $color3 =imagecolorallocate($image, mt_rand(100, 125), mt_rand(100, 125), mt_rand(100, 125));

        //在画布上画线
        imageline($image, mt_rand(0, 50), mt_rand(0, 25), mt_rand(0, 50), mt_rand(0, 25), $color1) ;
        imageline($image, mt_rand(0, 50), mt_rand(0, 20), mt_rand(0, 50), mt_rand(0, 20), $color2) ;
        imageline($image, mt_rand(0, 50), mt_rand(0, 20), mt_rand(0, 50), mt_rand(0, 20), $color3) ;

        //在画布上写字
        $text = substr(str_shuffle('ABCDEFGHIJKMNPRSTUVWXYZabcdefghijkmnprstuvwxyz23456789'), 0,4) ;
        imagestring($image, 5, 7, 5, $text, $color) ;
        session('code',$text);  //写入session
        //显示、销毁
        header('content-type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }


}