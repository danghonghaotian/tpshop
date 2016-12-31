<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/30
 * Time: 9:31
 */
namespace Home\Controller;
use Think\Controller;
class WeChatController extends Controller
{
    /**
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('404,该页面不存在',U('Home/Index/index'),1);
    }

    /**
     * 微信基础接入与响应
     */
    public function index()
    {
        define("TOKEN","weixin");
        $weChat = new \Helper\WeChatBase();
        if(!isset($_GET['echostr']))
        {
            //调用响应消息函数
            $weChat->responseMsg();
        }
        else
        {
            //实现网址接入，调用验证消息函数
            $weChat->valid();
        }
    }

    /**
     * 创建微信菜单
     */
    public function createMenu()
    {
        $appid = "wxc5e36ba4e1a17156";
        $appsecret = "c7c6fdbfaf838b0b01a3515c60f1ff06";
        $menu = new \Helper\WeChatMenu($appid,$appsecret );
        $data = "";
        $result =  $menu->menu_create($data);
        if($result)
        {
            $this->success("微信菜单创建成功");
        }
    }

    
    
    
}