<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/30
 * Time: 9:24
 * 微信基础接口
 */

namespace Helper;
class WeChatBase
{
//验证消息
    public function valid(){
        if($this->checkSignature())
        {
            $echostr = $_GET["echostr"];
            echo $echostr;
            exit;
        }
        else
        {
            echo "error";
            exit;
        }
    }

    //检查签名
    private function checkSignature()
    {
        //获取微信服务器GET请求的4个参数
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];

        //定义一个数组，存储其中3个参数，分别是timestamp，nonce和token
        $tempArr = array($nonce,$timestamp,TOKEN);

        //进行排序
        sort($tempArr,SORT_STRING);

        //将数组转换成字符串

        $tmpStr = implode($tempArr);

        //进行sha1加密算法
        $tmpStr = sha1($tmpStr);

        //判断请求是否来自微信服务器，对比$tmpStr和$signature
        if($tmpStr == $signature)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //响应消息
    public function responseMsg(){
        //根据用户传过来的消息类型进行不同的响应
        //1、接收微信服务器POST过来的数据，XML数据包

        $postData = $GLOBALS[HTTP_RAW_POST_DATA];

        if(!$postData)
        {
            echo  "error";
            exit();
        }

        //2、解析XML数据包

        $object = simplexml_load_string($postData,"SimpleXMLElement",LIBXML_NOCDATA);

        //获取消息类型
        $MsgType = $object->MsgType;
        switch ($MsgType) {
            case 'event':
                //接收事件推送
                $this->receiveEvent($object);
                break;
            case 'text':
                //接收文本消息
                echo $this->receiveText($object);
                break;
            case 'image':
                //接收图片消息
                echo $this->receiveImage($object);
                break;
            case 'location':
                //接收地理位置消息
                echo $this->receiveLocation($object);
                break;
            case 'voice':
                //接收语音消息
                echo $this->receiveVoice($object);
                break;
            case 'video':
                //接收视频消息
                echo $this->receiveVideo($object);
                break;
            case  'link':
                //接收链接消息
                echo $this->receiveLink($object);
                break;
            default:
                break;
        }
    }

    //接收事件推送
    private function receiveEvent($obj){
        switch ($obj->Event) {
            //关注事件
            case 'subscribe':
                //扫描带参数的二维码，用户未关注时，进行关注后的事件
                if(!empty($obj->EventKey)){
                    //做相关处理
                }
                $dataArray = array(
                    array(
                        "Title"=>"军哥带你玩转微信开发",
                        "Description"=>"this is a test",
                        "PicUrl"=>"http://yunkt.qiniudn.com/wxdzp_bg.jpg",
                        "Url"=>"http://2.lampym.vipsinaapp.com/index.php/bigwheel"
                    ),
                    array(
                        "Title"=>"晋赶1",
                        "Description"=>"this is a test",
                        "PicUrl"=>"https://wx.qq.com/cgi-bin/mmwebwx-bin/webwxgeticon?seq=621086533&username=gh_94ffcda815ac&skey=@crypt_d061de04_614219ccb4b916b642d16bcd4b795e4f",
                        "Url"=>"http://2.lampym.vipsinaapp.com/index.php/bigwheel"
                    ),
                );
                // echo replyText($obj,"欢迎你关注军哥带你玩转微信开发");
                echo $this->replyNews($obj,$dataArray);

                break;
            //取消关注事件
            case 'unsubscribe':
                break;
            //扫描带参数的二维码，用户已关注时，进行关注后的事件
            case 'SCAN':
                //做相关的处理
                break;
            //自定义菜单事件
            case 'CLICK':
                //
                switch ($obj->EventKey) {
                    case 'FAQ':
                        echo $this->replyText($obj,"你的点击的是FAQ事件");
                        break;
                    default:
                        echo $this->replyText($obj,"你的点击的是其他事件");
                        break;
                }
                break;
        }
    }

    //接收文本消息
    private function receiveText($obj){
        //获取文本消息的内容
        $content = $obj->Content;
        //发送文本消息
        return $this->replyText($obj,$content);
    }

    //接收图片消息
    private function receiveImage($obj)
    {
        //获取图片消息的内容
        $imageArr = array(
            "PicUrl"=>$obj->PicUrl,
            "MediaId"=>$obj->MediaId
        );
        //发送图片消息
        return $this->replyImage($obj,$imageArr);
    }

    //接收地理位置消息
    private function receiveLocation($obj)
    {
        //获取地理位置消息的内容
        $locationArr = array(
            "Location_X"=>$obj->Location_X,
            "Location_Y"=>"地址位置经度：".$obj->Location_Y,
            "Label"=>$obj->Label
        );
        //回复文本消息
        return $this->replyText($obj,$locationArr['Location_Y']);
    }

    //接收语言消息
    private function receiveVoice($obj){
        //获取语言消息内容
        $voiceArr = array(
            "MediaId"=>$obj->MediaId,
            "Format"=>$obj->Format
        );
        //回复语言消息
        return $this->replyVoice($obj,$voiceArr);
    }

    //接收视频消息
    private function receiveVideo($obj){
        //获取视频消息的内容
        $videoArr = array(
            "MediaId"=>$obj->MediaId
        );
        //回复视频消息
        return $this->replyVideo($obj,$videoArr);
    }

    //接收链接消息
    private function receiveLink($obj)
    {
        //接收链接消息的内容
        $linkArr = array(
            "Title"=>$obj->Title,
            "Description"=>$obj->Description,
            "Url"=>$obj->Url
        );
        //回复文本消息
        return $this->replyText($obj,"你发过来的链接地址是{$linkArr['Url']}");
    }

    //发送文本消息
    private function replyText($obj,$content){
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml,$obj->FromUserName,$obj->ToUserName,time(),$content);
        return $resultStr;
    }

    //发送图片消息
    private function replyImage($obj,$imageArr){
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[image]]></MsgType>
						<Image>
						<MediaId><![CDATA[%s]]></MediaId>
						</Image>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml,$obj->FromUserName,$obj->ToUserName,time(),$imageArr['MediaId']);
        return $resultStr;
    }

    //回复语音消息
    private function replyVoice($obj,$voiceArr)
    {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[voice]]></MsgType>
						<Voice>
						<MediaId><![CDATA[%s]]></MediaId>
						</Voice>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml,$obj->FromUserName,$obj->ToUserName,time(),$voiceArr['MediaId']);
        return $resultStr;
    }

    //回复视频消息
    private function replyVideo($obj,$videoArr){
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[video]]></MsgType>
						<Video>
						<MediaId><![CDATA[%s]]></MediaId>
						</Video> 
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml,$obj->FromUserName,$obj->ToUserName,time(),$videoArr['MediaId']);
        return $resultStr;
    }

    //回复音乐消息
    private function  replyMusic($obj,$musicArr)
    {
        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						<Music>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<MusicUrl><![CDATA[%s]]></MusicUrl>
						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
						<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
						</Music>
						</xml>";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml,$obj->FromUserName,$obj->ToUserName,time(),$musicArr['Title'],$musicArr['Description'],$musicArr['MusicUrl'],$musicArr['HQMusicUrl'],$musicArr['ThumbMediaId']);
        return $resultStr;
    }

    //回复图文消息
    private function replyNews($obj,$newsArr){
        $itemStr = "";
        if(is_array($newsArr))
        {
            foreach($newsArr as $item)
            {
                $itemXml ="<item>
						<Title><![CDATA[%s]]></Title> 
						<Description><![CDATA[%s]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
						</item>";
                $itemStr .= sprintf($itemXml,$item['Title'],$item['Description'],$item['PicUrl'],$item['Url']);
            }

        }

        $replyXml = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>%s</ArticleCount>
						<Articles>
							{$itemStr}
						</Articles>
						</xml> ";
        //返回一个进行xml数据包

        $resultStr = sprintf($replyXml,$obj->FromUserName,$obj->ToUserName,time(),count($newsArr));
        return $resultStr;
    }
}