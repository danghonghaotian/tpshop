<?php
/**
 * 图片处理类
 * User: 钟贵廷
 * Date: 2017/1/8
 * Time: 12:42
 */

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
    public static function getImageInfo($image)
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
        if(!file($dst) || !is_file($water))
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
     * 图像添加文字
     * @param  string  $dst 原图
     * @param  string  $save 存在位置
     * @param  string  $text   添加的文字
     * @param  string  $font   字体路径
     * @param  integer $size   字号
     * @param  string  $color  文字颜色
     * @param  integer $locate 文字写入位置
     * @param  integer $offset 文字相对当前位置的偏移量
     * @param  integer $angle  文字倾斜角度
     */
    public static function text($dst,$text, $font, $save=null,$size=40, $color = '#000000',$locate = self::IMAGE_WATER_SOUTHEAST, $offset = 0, $angle = 20)
    {
        //资源检测
        if(empty($dst)) die('没有可以被写入文字的图像资源');
        if(!is_file($font)) die("不存在的字体文件：{$font}");

        $dst_info = self::getImageInfo($dst);

        $dst_fun   = 'imagecreatefrom' . $dst_info['ext'];
        $new_dst = $dst_fun($dst);

        //获取文字信息
        $info = imagettfbbox($size, $angle, $font, $text);
        $minx = min($info[0], $info[2], $info[4], $info[6]);
        $maxx = max($info[0], $info[2], $info[4], $info[6]);
        $miny = min($info[1], $info[3], $info[5], $info[7]);
        $maxy = max($info[1], $info[3], $info[5], $info[7]);

        /* 计算文字初始坐标和尺寸 */
        $x = $minx;
        $y = abs($miny);
        $w = $maxx - $minx;
        $h = $maxy - $miny;

        /* 设定文字位置 */
        switch ($locate) {
            /* 右下角文字 */
            case self::IMAGE_WATER_SOUTHEAST:
                $x += $dst_info['width']  - $w;
                $y += $dst_info['height'] - $h;
                break;

            /* 左下角文字 */
            case self::IMAGE_WATER_SOUTHWEST:
                $y += $dst_info['height'] - $h;
                break;

            /* 左上角文字 */
            case self::IMAGE_WATER_NORTHWEST:
                // 起始坐标即为左上角坐标，无需调整
                break;

            /* 右上角文字 */
            case self::IMAGE_WATER_NORTHEAST:
                $x += $dst_info['width'] - $w;
                break;

            /* 居中文字 */
            case self::IMAGE_WATER_CENTER:
                $x += ($dst_info['width']  - $w)/2;
                $y += ($dst_info['height'] - $h)/2;
                break;

            /* 下居中文字 */
            case self::IMAGE_WATER_SOUTH:
                $x += ($dst_info['width'] - $w)/2;
                $y += $dst_info['height'] - $h;
                break;

            /* 右居中文字 */
            case self::IMAGE_WATER_EAST:
                $x += $dst_info['width'] - $w;
                $y += ($dst_info['height'] - $h)/2;
                break;

            /* 上居中文字 */
            case self::IMAGE_WATER_NORTH:
                $x += ($dst_info['width'] - $w)/2;
                break;

            /* 左居中文字 */
            case self::IMAGE_WATER_WEST:
                $y += ($dst_info['height'] - $h)/2;
                break;

            default:
                /* 自定义文字坐标 */
                if(is_array($locate)){
                    list($posx, $posy) = $locate;
                    $x += $posx;
                    $y += $posy;
                } else {
                    die('不支持的文字位置类型');
                }
        }

        /* 设置偏移量 */
        if(is_array($offset)){
            $offset = array_map('intval', $offset);
            list($ox, $oy) = $offset;
        } else{
            $offset = intval($offset);
            $ox = $oy = $offset;
        }

        /* 设置颜色 */
        if(is_string($color) && 0 === strpos($color, '#')){
            $color = str_split(substr($color, 1), 2);
            $color = array_map('hexdec', $color);
            if(empty($color[3]) || $color[3] > 127){
                $color[3] = 0;
            }
        } elseif (!is_array($color)) {
            die('错误的颜色值');
        }

        if(!$save)
        {
            $save = $dst;
            unlink($dst);
        }

        /* 写入文字 */
        $col = imagecolorallocatealpha($new_dst, $color[0], $color[1], $color[2], $color[3]);
        imagettftext($new_dst, $size, $angle, $x + $ox, $y + $oy, $col, $font, $text);
        $createfunc = 'image' . $dst_info ['ext'];
        $createfunc($new_dst,$save);
        imagedestroy($new_dst);

    }




}