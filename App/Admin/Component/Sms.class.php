<?php
/**
 * 跃飞科技版权所有 @2016
 */
namespace Admin\Component;
class Sms
{
 		
	//您获取到的用户名
	private $_username;
	//您获取到的密码
	private $_password ;
	
	const SEND_SUCCESS = 1; //发送成功
	const INVALID_COMMAND = 2; //无效的command参数
	const ACCOUNT_ERROR = 3; //账号信息错误
	const PASSWORD_ERROR = 4; //账号密码错误
	const FORMAT_ERROR = 5; //目标号码格式错误或群发号码数量超过100个
	const UNKNOWN_ERROR = 6; //未知错误
	const REQUEST_ERROR = 7;  //请求参数错误;

	public function __construct($username,$password)
	{
		$this->_username = "m6uzkn";
		$this->_password = "QGzKFw1l";
	}
	
	//服务器请求地址
	private $request_url = 'http://api2.santo.cc/submit';

	/**
     * 海客信使获取发送请求地址
     *
     * 详细说明
     * @形参
	 * $mobile		发送手机(前缀加地区编码，如中国：8613800138000)
     * $message     发送消息
     *
     * @访问      公有
     * @返回值    string
     * @throws
     * helius
     */
	 function getRequestUrl($mobile,$message,$encode_code = 15)
	 {
	 	$request = array(
			'command'	=>'MT_REQUEST',
			'cpid'		=>$this->_username,
			'cppwd'		=>$this->_password,
			'da'		=>$mobile,
			'dc'		=>$encode_code,
			'sm'		=>$this->santoEncode($message,$encode_code),
		);
		
		return $this->request_url.'?'.http_build_query($request);
	 }

    /**
     * 海客信使短信内容编码
     *
     * 详细说明
     * @形参
     * $message     发送消息
     * $encode_code 发送编码代号，取值：
     *      15   ：GBK
     *      0    ：ISO-8859-1
     *      8	 ：UTF-16BE
     *
     * @访问      公有
     * @返回值    string
     * @throws
     * helius
     */
    function santoEncode($message,$encode_code = 15)
    {
        $code2Encodetype = array(
            0   =>'ISO-8859-1',
			8	=>'UTF-16BE',
            15  =>'GBK',
        );

        if(empty($code2Encodetype[$encode_code]))
        {
            throw new Exception('Encode_type Error');
        }

        $message = mb_convert_encoding($message,$code2Encodetype[$encode_code],'auto');

        return bin2hex($message);
    }
    
    /**
     * 发送url请求到信息服务器
     * @param string $url 信息服务器地址
     * @return int
     */
    public function sendSMS($url)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		$code = $this->sendOKorNot($output); //返回的状态
		return  $code;
    }
    
    /**
     * 发送是否成功返回状态码
     * 	const SEND_SUCCESS = 1; //发送成功
	 *	const INVALID_COMMAND = 2; //无效的command参数
	 *	const ACCOUNT_ERROR = 3; //账号信息错误
	 *	const PASSWORD_ERROR = 4; //账号密码错误
	 *	const FORMAT_ERROR = 5; //目标号码格式错误或群发号码数量超过100个
	 *	const UNKNOWN_ERROR = 6; //未知错误
	 *  const REQUEST_ERROR = 7;  //请求参数错误
     * @param string $str
     * @return int
     */
    private function sendOKorNot($str)
    {
	    $arr = explode('&', $str);
	    //发送成功
	    if($arr[4]== "mtstat=ACCEPTD" && $arr[5] == "mterrcode=000")
	    {
	    	return  self::SEND_SUCCESS;
	    }
	    //发送失败
    	if($arr[3]== "mtstat=REJECTD")
	    {
	    	$code = explode("=", $arr[4]);
	    	switch ($code[1])
	    	{
	    		case "0101":
	    			return  self::INVALID_COMMAND;
   					break;
   				case "0100":
   					return  self::REQUEST_ERROR; 
   					break;
   				case "0104":
   					return  self::ACCOUNT_ERROR;
   					break;
   				case  "0106":
   					return  self::PASSWORD_ERROR;
   					break;
   				case "0110":
   					return  self::FORMAT_ERROR;
   					break;
   				case "0600":
   					return  self::UNKNOWN_ERROR;
   					break;
	    	}
	    }
	    
    }
    
    
    /**
     * 获取西班牙国家正确的手机号码
     * @param int $phoneNum
     * @return bool
     */
    public function isCorrectSpainPhone($phoneNum)
    {
    	$pattern = '/^(6|7)\d{8}$/';
    	return preg_match($pattern, trim($phoneNum))?TRUE:FALSE;
    }
    
    /**
     * 获取葡萄牙国家正确的手机号码
     * @param int $phoneNum
     * @return bool
     */
    public function isCorrectPortugalPhone($phoneNum)
    {
    	$pattern = '/^9\d{8}$/';
    	return preg_match($pattern, trim($phoneNum))?TRUE:FALSE;
    }
    
    
    /**
     * 获取德语正确的手机号码
     * @param int $phoneNum
     * @return bool
     */
    public function isCorrectGermanPhone($phoneNum)
    {
    	$pattern = '/^\d{11}$/';
    	return preg_match($pattern, trim($phoneNum))?TRUE:FALSE;
    }
    
    
}