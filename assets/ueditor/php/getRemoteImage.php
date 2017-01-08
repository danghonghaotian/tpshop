<?php
    /**
     * Created by JetBrains PhpStorm.
     * User: taoqili
     * Date: 11-12-28
     * Time: 上午9:54
     * To change this template use File | Settings | File Templates.
     */
    header("Content-Type: text/html; charset=utf-8");
    error_reporting(E_ERROR|E_WARNING);
    //远程抓取图片配置

    $rootPath =  $_SERVER['DOCUMENT_ROOT'];
    // 构造图片存放目录的路径
    $date = date('Y-m',time());
    //目录结构宽高/年月组成
    $dir =$rootPath."/assets/upload/editor/$date";
    if(!is_dir($dir))
    {
        mkdir($dir, 0777,true);
    }
    $config = array(
        "savePath" => "../../upload/editor/$date/" ,            //保存路径
        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ) , //文件允许格式
        "maxSize" => 3000,                    //文件大小限制，单位KB
        "waterImg" =>'./upload/water.jpg', //水印图片
        "location" =>5, //水印位置，居中（请看扩展类ImageTool）；
        "afterSavePath" =>null, //添加水印后图片保存位置，默认原图替换
        "text" =>'跃飞科技版权所有',//水印文字
        "fontLocation" =>'./font/simkai.ttf', //字体位置
        "color" =>'#fd0303', //字体颜色
        "size"=>60

    );
    $uri = htmlspecialchars( $_POST[ 'upfile' ] );
    $uri = str_replace( "&amp;" , "&" , $uri );
    getRemoteImage( $uri,$config );

    /**
     * 远程抓取
     * @param $uri
     * @param $config
     */
    function getRemoteImage( $uri,$config)
    {
        //忽略抓取时间限制
        set_time_limit( 0 );
        //ue_separate_ue  ue用于传递数据分割符号
        $imgUrls = explode( "ue_separate_ue" , $uri );
        $tmpNames = array();
        foreach ( $imgUrls as $imgUrl ) {
            //http开头验证
            if(strpos($imgUrl,"http")!==0){
                array_push( $tmpNames , "error" );
                continue;
            }
            //获取请求头
            $heads = get_headers( $imgUrl );
            //死链检测
            if ( !( stristr( $heads[ 0 ] , "200" ) && stristr( $heads[ 0 ] , "OK" ) ) ) {
                array_push( $tmpNames , "error" );
                continue;
            }

            //格式验证(扩展名验证和Content-Type验证)
            $fileType = strtolower( strrchr( $imgUrl , '.' ) );
            if ( !in_array( $fileType , $config[ 'allowFiles' ] ) || stristr( $heads[ 'Content-Type' ] , "image" ) ) {
                array_push( $tmpNames , "error" );
                continue;
            }

            //打开输出缓冲区并获取远程图片
            ob_start();
            $context = stream_context_create(
                array (
                    'http' => array (
                        'follow_location' => false // don't follow redirects
                    )
                )
            );
            //请确保php.ini中的fopen wrappers已经激活
            readfile( $imgUrl,false,$context);
            $img = ob_get_contents();
            ob_end_clean();

            //大小验证
            $uriSize = strlen( $img ); //得到图片大小
            $allowSize = 1024 * $config[ 'maxSize' ];
            if ( $uriSize > $allowSize ) {
                array_push( $tmpNames , "error" );
                continue;
            }
            //创建保存位置
            $savePath = $config[ 'savePath' ];
            if ( !file_exists( $savePath ) ) {
                mkdir( "$savePath" , 0777 );
            }
            //写入文件
            $tmpName = $savePath . rand( 1 , 10000 ) . time() . strrchr( $imgUrl , '.' );
            try {
                $fp2 = @fopen( $tmpName , "a" );
                fwrite( $fp2 , $img );
                fclose( $fp2 );
                array_push( $tmpNames ,  $tmpName );
            } catch ( Exception $e ) {
                array_push( $tmpNames , "error" );
            }
        }

        //给远程图片添加水印
        include "ImageTool.class.php";
        foreach ($tmpNames as $k=>$v)
        {
            //图片水印，透明度不好调
//            ImageTool::water($v,$config['waterImg'],$config['afterSavePath'],$config['location'] );
            //文字水印
            ImageTool::text($v,$config['text'],$config['fontLocation'],$config['afterSavePath'],$config['size'],$config['color'],$config['location']);
        }

        /**
         * 返回数据格式
         * {
         *   'url'   : '新地址一ue_separate_ue新地址二ue_separate_ue新地址三',
         *   'srcUrl': '原始地址一ue_separate_ue原始地址二ue_separate_ue原始地址三'，
         *   'tip'   : '状态提示'
         * }
         */
        echo "{'url':'" . implode( "ue_separate_ue" , $tmpNames ) . "','tip':'远程图片抓取成功！','srcUrl':'" . $uri . "'}";
    }