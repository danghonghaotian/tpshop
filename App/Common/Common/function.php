<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/18
 * Time: 14:07
 * 公共函数库使用
 *  array2excel($data,$filename='simple.xls')
 *  excel2array($filePath='',$sheet=0)
 *  sendEmail($emailAddress,$username,$subject,$content)
 *  TPSIsMobile()
 *  TPSSendSMS2($phoneNumber,$content)
 *  TPSSendSMS($phoneNumber,$content)
 *  TPSIPAddress($queryIP)
 */

/**
 * 导出excel格式的文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
    $data = array(
    array(NULL, 2010, 2011, 2012),
    array('Q1',   12,   15,   21),
    array('Q2',   56,   73,   86),
    array('Q3',   52,   61,   69),
    array('Q4',   30,   32,    0),
    );
 */
function array2excel($data,$filename='simple.xls')
{
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    $filename=str_replace('.xls', '', $filename).'.xls';
    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}


/**
 * 将excel文件装换成数组格式
 * @param string $filePath
 * @param int $sheet
 * @return array|void
 */
function excel2array($filePath='',$sheet=0)
{
    if(empty($filePath) or !file_exists($filePath)){die('file not exists');}
    Vendor('PHPExcel.PHPExcel');
    $PHPReader = new PHPExcel_Reader_Excel2007();        //建立reader对象
    if(!$PHPReader->canRead($filePath)){
        $PHPReader = new PHPExcel_Reader_Excel5();
        if(!$PHPReader->canRead($filePath)){
            echo 'no Excel';
            return ;
        }
    }
    $PHPExcel = $PHPReader->load($filePath);        //建立excel对象
    $currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
    $allColumn = $currentSheet->getHighestColumn();        //**取得最大的列号*/
    $allRow = $currentSheet->getHighestRow();        //**取得一共有多少行*/
    $data = array();
    for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
        for($colIndex='A';$colIndex<=$allColumn;$colIndex++){
            $addr = $colIndex.$rowIndex;
            $cell = $currentSheet->getCell($addr)->getValue();
            if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                $cell = $cell->__toString();
            }
//            $data[$rowIndex][$colIndex] = $cell;
            $data[$rowIndex][] = $cell;
        }
    }
    return $data;
}


/**
 * 发送邮件
 * @param $emailAddress
 * @param $username
 * @param $subject
 * @param $content
 * @return bool|string
 * 返回正确或者错误信息
 */
function sendEmail($emailAddress,$username,$subject,$content)
{
    Vendor('PHPMailer.class#phpmailer');
    $mail  = new PHPMailer();
    $mail->IsSMTP();                // send via SMTP
    $mail->Host = C('EMAIL_HOST'); // SMTP servers
//        $mail->SMTPDebug  = C('EMAIL_SMTP_DEBUG');
    $mail->SMTPAuth = true;         // turn on SMTP authentication
    $mail->Username = C('EMAIL_USERNAME');   // SMTP username  注意：普通邮件认证不需要加 @域名
    $mail->Password =C('EMAIL_PASSWORD');        // SMTP password
    $mail->From = C('EMAIL_FROM');      // 发件人邮箱
    $mail->FromName =  C('EMAIL_FROM_NAME');  // 发件人显示，收件邮箱的发件人名称
    $mail->CharSet = "utf-8";            // 这里指定字符集！
    $mail->Encoding = "base64";
    $mail->AddAddress($emailAddress,$username);  // 收件人邮箱和姓名
    $mail->IsHTML(true);  // send as HTML
    // 邮件主题
    $mail->Subject = $subject;
    // 邮件内容
    $mail->Body =$content;
    $mail->AltBody ="text/html";
    return $mail->Send()?true:false;
}


/**
 * 判断是否手机访问
 */
function TPSIsMobile()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $mobile_browser++;
    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;
    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;
    if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda','xda-'
    );
    if(in_array($mobile_ua, $mobile_agents))$mobile_browser++;
    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)$mobile_browser++;
    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)$mobile_browser=0;
    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)$mobile_browser++;
    if($mobile_browser>0){
        return true;
    }else{
        return false;
    }
}

/**
 * 发送短信
 * 此接口要根据不同的短信服务商去写，这里只是一个参考
 * @param string $phoneNumber  手机号码
 * @param string $content     短信内容
 */
function TPSSendSMS2($phoneNumber,$content)
{
    $url = 'http://223.4.21.214:8180/service.asmx/SendMessage?Id='.$GLOBALS['CONFIG']['smsOrg']."&Name=".$GLOBALS['CONFIG']['smsKey']."&Psw=".$GLOBALS['CONFIG']['smsPass']."&Timestamp=0&Message=".$content."&Phone=".$phoneNumber;
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置否输出到页面
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30 ); //设置连接等待时间
    curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
    $data=curl_exec($ch);
    curl_close($ch);
    return "$data";
}

/**
 * 发送短信
 * 此接口要根据不同的短信服务商去写，这里只是一个参考
 * @param $phoneNumber
 * @param $content
 * @return mixed
 */
function TPSSendSMS($phoneNumber,$content)
{
    $url = 'http://utf8.sms.webchinese.cn/?Uid='.$GLOBALS['CONFIG']['smsKey'].'&Key='.$GLOBALS['CONFIG']['smsPass'].'&smsMob='.$phoneNumber.'&smsText='.$content;
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置否输出到页面
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30 ); //设置连接等待时间
    curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
    $data=curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * 根据IP获取ip所在地
 * @param $queryIP
 * @return array
 */
function TPSIPAddress($queryIP)
{
    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_ENCODING ,'utf8');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $location = curl_exec($ch);
    curl_close($ch);
    if($location)
    {
        $location = json_decode($location);
        return array('country'=>$location->country,'province'=>$location->province,'city'=>$location->city);
    }
    return array();
}


/**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function TPSRealIp()
{
    static $realIp = NULL;

    if ($realIp !== NULL)
    {
        return $realIp;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realIp = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realIp = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realIp = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realIp = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realIp = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realIp = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realIp = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realIp, $onlineIp);
    $realIp = !empty($onlineIp[0]) ? $onlineIp[0] : '0.0.0.0';

    return $realIp;
}

/**
 * 获取服务器的ip
 * @access  public
 * @return string
 */
function TPSRealServerIp()
{
    static $serverIp = NULL;

    if ($serverIp !== NULL)
    {
        return $serverIp;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['SERVER_ADDR']))
        {
            $serverIp = $_SERVER['SERVER_ADDR'];
        }
        else
        {
            $serverIp = '0.0.0.0';
        }
    }
    else
    {
        $serverIp = getenv('SERVER_ADDR');
    }

    return $serverIp;
}

/**
 * 查询快递
 * @param $postcom  快递公司(中文名称或者查询代码)
 * @param $getNu  快递单号
 * @return array   物流跟踪信息数组
 */
function queryExpress($postcom , $getNu){
    if(isset($postcom) && isset($getNu)){
        //请将appkey替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
        $AppKey=C('KUAIDI100_APP_KEY');
        //show=0,返回json格式，1：xml格式2，html格式
        $url ='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$postcom.'&nu='.$getNu.'&show=0&muti=1&order=asc';
        //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
//        $powered = '查询服务由：<a href="http://www.kuaidi100.com" target="_blank" style="color:blue">快递100</a> 网站提供';
        //优先使用curl模式发送数据
        if (function_exists('curl_init') == 1){
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt ($curl, CURLOPT_HEADER,0);
            curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
            curl_setopt ($curl, CURLOPT_TIMEOUT,5);
            $get_content = curl_exec($curl);
            curl_close ($curl);
        }else{
            vendor('kuaidi100.snoopy');
            $snoopy = new snoopy();
            $snoopy->referer = 'http://www.google.com/';//伪装来源
            $snoopy->fetch($url);
            $get_content = $snoopy->results;
        }
        return json_decode($get_content,true);
    }else{
        return array('status'=>0,'message'=>'查询失败，参数有误');
    }
}

/**生成条形码
 * @param $text
 * @param int $type
 * @link  http://www.barcodebakery.com/en/resources/api/php/ean13
 */
function generateBarCode($text,$type=13)
{
// Including all required classes
    Vendor('Barcode.BCGFont');
    Vendor('Barcode.BCGColor');
    Vendor('Barcode.BCGDrawing');
// Including the barcode technology
    //引入生成条形码的类型类
    if($type == 39)
    {
        Vendor('Barcode.BCGcode39#barcode');
    }
    elseif($type == 13)
    {
         Vendor('Barcode.BCGean13#barcode');
    }
// Loading Font
//    $font = new BCGFont('./ThinkPHP/Library/Vendor/Barcode/font/Arial.ttf', 18);
// The arguments are R, G, B for color.
    $color_black = new BCGColor(0, 0, 0);
    $color_white = new BCGColor(255, 255, 255);
    //生成条形码类型
    if($type == 39)
    {
        $code = new BCGcode39();
    }
    elseif ($type == 13)
    {
        $code = new BCGean13();
    }
    $code->setScale(2); // Resolution 细度
    $code->setThickness(60); // Thickness 高度
    $code->setForegroundColor($color_black); // Color of bars
    $code->setBackgroundColor($color_white); // Color of spaces
//    $code->setFont($font); // Font (or 0)
    $code->setFont(0); // Font (or 0)
    $code->parse($text); // Text
    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('', $color_white);
    $drawing->setBarcode($code);
    $drawing->draw();
// Header that says it is an image (remove it if you save the barcode to a file)
    header('Content-Type: image/png');
// Draw (or save) the image into PNG format.
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
}

/**
 * 生成二维码
 * @param $url 链接
 * @param int $size 大小
 */
function generateQrCode($url,$size=4)
{
    Vendor('phpqrcode.phpqrcode');
    // 如果没有http 则添加
    if (strpos($url, 'http')===false)
    {
        $url='http://'.$url;
    }
    QRcode::png($url, false, QR_ECLEVEL_L, $size);
}

/**
 * 生成pdf文档
 * @param $title 标题
 * @param $content 内容
 * @param string $file  不能为中文名
 */
function generatePDF($title,$content,$file='example.pdf')
{
    Vendor('tcpdf.tcpdf');
    //实例化
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    // 设置文档信息
    $pdf->SetCreator('gtzhong');
    $pdf->SetAuthor('gtzhong');
    $pdf->SetTitle($title);
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('geekvida.com, www.tomrepair.es, www.tomrepair.us');
    // 设置页眉和页脚信息
    $pdf->SetHeaderData('ecshop_logo.gif', PDF_HEADER_LOGO_WIDTH, $title, "by 丹宏昊天 - www.geekvida.com\nwww.tomrepair.es", array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    // 设置页眉和页脚字体
    $pdf->setHeaderFont(Array('stsongstdlight', '', '10'));
    $pdf->setFooterFont(Array('helvetica', '', '8'));
    // 设置默认等宽字体
    $pdf->SetDefaultMonospacedFont('courier');
    // 设置间距
    $pdf->SetMargins(15, 27, 15);
    $pdf->SetHeaderMargin(5);
    $pdf->SetFooterMargin(10);
    // 设置分页
    $pdf->SetAutoPageBreak(TRUE, 25);
    // set image scale factor
    $pdf->setImageScale(1.25);
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);
    //设置字体
    $pdf->SetFont('stsongstdlight', '', 14);
    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
    //输出PDF
    $pdf->Output($file, 'I');
}

/**
 * 判断当前服务器使用协议类型
 * @return string
 */
function http_type()
{
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    return $http_type;
}


/**
 * 获取本站完整网址
 * @return string
 */
function getWebsite()
{
    return http_type().$_SERVER['SERVER_NAME'];
}

/**
 * 判断是否是首页
 * @return bool
 */
function isHome()
{
    if(MODULE_NAME == 'Home' && CONTROLLER_NAME == 'Index' && ACTION_NAME == 'index')
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * 判断当前导航栏是否选中
 * @param $url
 * @return bool
 */
function isCurrent($url)
{
    if(strpos($_SERVER['REQUEST_URI'],$url) !== false)
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * 根据当前时间返回周期第一天，跟最后一天
 * @param $time
 * @return array
 */
function getDay($time)
{
    $last_day=date("Y-m-d",strtotime("$time Sunday"));
    $first_day = date("Y-m-d",strtotime("$last_day - 6 days"));
    return array(
        'first_day'=>$first_day,
        'last_day'=>$last_day
    );
}

/**
 * 字符串中是否有中文
 * @param $str
 * @return bool
 */
function is_cn_font($str,$code='utf-8')
{
    if($code == 'utf-8')
    {
        if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$str)) //UTF-8汉字字母数字下划线正则表达式
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    if($code == 'GB2312')
    {
        if(!preg_match("/^[".chr(0xa1)."-".chr(0xff)."A-Za-z0-9_]+$/",$str)) //GB2312汉字字母数字下划线正则表达式
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

/**
 * 格式化价格为两位小数
 * @param $num
 * @return string
 */
function formatPrice($num)
{
    return sprintf("%.2f",$num);
}

/**
 * 将时间戳转换成时间格式
 * @param $time
 * @return string
 */
function formatDate($time)
{
    return date("Y-m-d H:i:s",$time);
}

?>