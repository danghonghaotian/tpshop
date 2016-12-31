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
        array('email',"is_email","电子邮箱格式不正确!",self::MUST_VALIDATE,callback),
        array("email","","该电子邮件已经被注册",self::MUST_VALIDATE,'unique'),

        array('password', 'require', '密码不能为空！', 1, 'regex', self::MODEL_INSERT),
        array('password',"checkPasswordLength","6-20位字符，可使用字母、数字和符号的组合，不建议使用纯数字、纯字母、纯符号",self::MUST_VALIDATE,callback),
        array('re_password',"checkPasswordValid","确认密码不一致",self::MUST_VALIDATE,callback),
    );


    protected $_auto = array (
        array('password','md5',1,'function') ,
        array('reg_time','time',1,'function')
    );


    /**
     * 自定义校验邮箱，抄袭ec_shop
     * @param $user_email
     * @return bool
     */
    public function is_email($user_email)
    {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,3}\$/i";
        if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
        {
            if (preg_match($chars, $user_email))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
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
        if($_POST['password'] != $re_password)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 异步校验邮箱是否被注册
     * @param $email
     * @return bool
     */
    public function ajaxCheckEmail($email)
    {
        $res = $this->where(array('email'=>$email))->find();
        return $res?false:true;
    }


    /**
     * 用户注册邮箱模板
     * @param $email
     * @param $website
     * @return string
     */
    public function getRegisterTemplate($email,$website)
    {
        $content = <<<EOF
        <table width="675" border="0" style="font-family:Helvetica, Arial, sans-serif">
            <tr>
                <td height="132" align="left">
                    <a href="$website">
                        <img title="gv商城" alt="tpshop" src="$website/assets/home/images/logo.png"  width="221" height="39" longdesc="$website" />
                    </a>
                </td>
            </tr>
            <tr>
                <td align="left"> 
                   恭喜你注册成功，请在24小时内激活邮箱登陆<a href="$website/index.php/Home/User/active/email/$email">$website/index.php/Home/User/active/email/$email</a>
                </td>
            </tr>
        </table>
EOF;
        return $content;

    }



}