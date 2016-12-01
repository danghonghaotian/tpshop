<?php
/**
 * 跃飞科技版权所有 @2016
 */

/**
 * User: zhong
 * Date: 2016/7/26
 * Time: 14:57
 */

namespace Admin\Model;


use Think\Model;
class SmsModel extends Model
{
    protected $_validate = array(
      array('ordernumber',"require","订单号必须!"),
      array('ordernumber',"checkOrderNumber","订单号不正确!",self::MUST_VALIDATE,callback),
      array('phonenumber',"require","手机号码必须!"),
      array('phonenumber',"checkPhoneNumber","手机号不正确!",self::MUST_VALIDATE,callback),
      array("content","require","发送内容必须"),
      array("content","","短信内容重复",self::MUST_VALIDATE,'unique'),
    );


    protected $_auto = array(
        array('created_at','time',self::MODEL_INSERT,'function')
    );

    /**
     * 检查订单号是否正确
     * @param $ordernumber
     * @return bool
     */
    public function checkOrderNumber($ordernumber)
    {
        $pattern = "/^\d{9}$/";
        return preg_match($pattern, $ordernumber)?true:false;
    }

    /**
     * 检查手机号是否正确
     * @param $phone
     * @return bool
     */
    public function checkPhoneNumber($phone)
    {
        $pattern = "/^1\d{10}$/";
        return preg_match($pattern, $phone)?true:false;
    }


    public function fieldName()
    {
        return array(
            'id'=>'<input type="checkbox" id="allCheck" >编号',
            'ordernumber'=>'订单号',
            'phonenumber'=>'手机号码',
            'content'=>'发送内容',
            'sendtype'=>'发送类型',
            'status'=>'发送状态',
            'created_at'=>'发送时间',
            'option'=>'操作'
        );
    }

    public function getStatus()
    {
        $status = array();
        $status['0'] = "待发";
        $status['1'] = "发送成功";
        $status['2'] = "无效的command参数";
        $status['3'] = "账号信息错误";
        $status['4'] = "账号密码错误";
        $status['5'] = "目标号码格式错误";
        $status['6'] = "未知错误";
        $status['7'] = "请求参数错误";
        return $status;
    }

    public function getSendType()
    {
        $sendType = array();
        $sendType["0"] = "下单";
        $sendType["1"] = "发货";
        return $sendType;
    }


    public function search($condition)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = $condition;
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $page->setConfig('prev',  '上一页');
        $page->setConfig('next',  '下一页');
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->show();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->order("sms_id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }

}