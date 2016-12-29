<?php
/**
 * 用户模型
 * User: 钟贵廷
 * Date: 2016/12/29
 * Time: 20:49
 */

namespace Home\Model;
use Think\Model;

class UserModel extends Model
{
    protected $_validate = array(
        array('verify', 'check_verify', '验证码不正确', 0, 'callback'),

        array('email',"require","电子邮箱不能为空!"),
        array('email',"email","电子邮箱格式不正确!"),
        array("email","","该电子邮件已经被注册",self::MUST_VALIDATE,'unique'),

        array('password', 'require', '密码不能为空！', 1, 'regex', self::MODEL_INSERT),
        array('password',"checkPasswordLength","6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号",self::MUST_VALIDATE,callback),
        array('re_password',"checkPasswordValid","确认密码不一致",self::MUST_VALIDATE,callback),
    );


    protected $_auto = array (
        array('password','md5',1,'function') , // 对password字段在新增的时候使md5函数处理
        array('reg_time','time',1,'function') // 对reg_time字段在更新的时候写入当前时间戳
    );

    
    /**
     * 验证码校验
     * @param $code
     * @return bool
     */
    function check_verify($code)
    {
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    /**
     * 检查密码长度
     * @param $password
     * @return bool
     */
    public function checkPasswordLength($password)
    {
        if(strlen($password)<6 || strlen($password)>20)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 校验密码是否一致
     * @param $re_password
     * @return bool
     */
    public function checkPasswordValid($re_password)
    {
        if($this->password != $re_password)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}