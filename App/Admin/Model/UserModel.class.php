<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/25
 * Time: 13:33
 */

namespace Admin\Model;
use Think\Model;
use Admin\Component;
class UserModel extends Model
{
    protected $_validate = array(
        array('username',"require","会员名不能为空"),
        array('username',"checkUserLength","会员名称长度必须在3-16位之间!",self::MUST_VALIDATE,callback),
        array("username","","会员已被注册",self::MUST_VALIDATE,'unique'),
        array('password',"require","密码不能为空",self::MUST_VALIDATE,"",self::MODEL_INSERT),
        array('phone_number',"require","手机号码不能为空!"),
        array('phone_number',"isMobile","手机格式不正确",self::MUST_VALIDATE,callback),
        array("phone_number","","该号码已被注册",self::MUST_VALIDATE,'unique'),
        array('email',"require","邮箱地址不能为空"),
        array('email',"isEmail","邮箱格式不正确",self::MUST_VALIDATE,callback),
        array("email","","该邮箱已被注册",self::MUST_VALIDATE,'unique'),
    );

    /**
     * 检查会员名称长度
     * @param $username
     * @return bool
     */
    public function checkUserLength($username)
    {
        $username = trim($username);
        if(strlen($username)>=3 && strlen($username)<=16)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * 检查邮箱
     * ecshop函数库代码
     * @param $user_email
     * @return bool
     */
    public function isEmail($user_email)
    {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
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
     * 检测手机号码是否正确
     * ecshop函数库代码
     */
    public function isMobile($phone_number)
    {
        return  preg_match("/^0?1((3|8)[0-9]|5[0-35-9]|4[57])\d{8}$/", $phone_number)?true:false;
    }


    /**
     * 搜索
     * @return array
     */
    public function search($keyword)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        $where .= " and (username like '%$keyword%' or email like '%$keyword%' or phone_number like '%$keyword%')";
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个会员';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->order("user_id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }
}