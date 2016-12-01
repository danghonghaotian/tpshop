<%
' 功能：即时到账交易接口接入页
' 版本：3.3
' 日期：2012-07-17
' 说明：
' 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
' 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
	
' /////////////////注意/////////////////
' 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
' 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
' 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
' 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
' /////////////////////////////////////

%>
<html>
<head>
	<META http-equiv=Content-Type content="text/html; charset=gb2312">
<title>支付宝即时到账交易接口</title>
</head>
<body>

<!--#include file="class/alipay_submit.asp"-->

<%
'/////////////////////请求参数/////////////////////

        '支付类型
        payment_type = "1"
        '必填，不能修改
        '服务器异步通知页面路径
        notify_url = "http://www.xxx.com/create_direct_pay_by_user-ASP-GBK/notify_url.asp"
        '需http://格式的完整路径，不能加?id=123这类自定义参数
        '页面跳转同步通知页面路径
        return_url = "http://www.xxx.com/create_direct_pay_by_user-ASP-GBK/return_url.asp"
        '需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        '卖家支付宝帐户
        seller_email = Request.Form("WIDseller_email")
        '必填
        '商户订单号
        out_trade_no = Request.Form("WIDout_trade_no")
        '商户网站订单系统中唯一订单号，必填
        '订单名称
        subject = Request.Form("WIDsubject")
        '必填
        '付款金额
        total_fee = Request.Form("WIDtotal_fee")
        '必填
        '订单描述
        body = Request.Form("WIDbody")
        '商品展示地址
        show_url = Request.Form("WIDshow_url")
        '需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html
        '防钓鱼时间戳
        anti_phishing_key = ""
        '若要使用请调用类文件submit中的query_timestamp函数
        '客户端的IP地址
        exter_invoke_ip = ""
        '非局域网的外网IP地址，如：221.0.0.1

'/////////////////////请求参数/////////////////////

'构造请求参数数组
sParaTemp = Array("service=create_direct_pay_by_user","partner="&partner,"_input_charset="&input_charset  ,"payment_type="&payment_type   ,"notify_url="&notify_url   ,"return_url="&return_url   ,"seller_email="&seller_email   ,"out_trade_no="&out_trade_no   ,"subject="&subject   ,"total_fee="&total_fee   ,"body="&body   ,"show_url="&show_url   ,"anti_phishing_key="&anti_phishing_key   ,"exter_invoke_ip="&exter_invoke_ip  )

'建立请求
Set objSubmit = New AlipaySubmit
sHtml = objSubmit.BuildRequestForm(sParaTemp, "get", "确认")
response.Write sHtml


%>
</body>
</html>
