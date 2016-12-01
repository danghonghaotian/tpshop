<%
' 功能：即时到账批量退款有密接口接入页
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
<title>支付宝即时到账批量退款有密接口</title>
</head>
<body>

<!--#include file="class/alipay_submit.asp"-->

<%
'/////////////////////请求参数/////////////////////

        '服务器异步通知页面路径
        notify_url = "http://www.xxx.com/refund_fastpay_by_platform_pwd-ASP-GBK/notify_url.asp"
        '需http://格式的完整路径，不允许加?id=123这类自定义参数
        '卖家支付宝帐户
        seller_email = Request.Form("WIDseller_email")
        '必填
        '退款当天日期
        refund_date = Request.Form("WIDrefund_date")
        '必填，格式：年[4位]-月[2位]-日[2位] 小时[2位 24小时制]:分[2位]:秒[2位]，如：2007-10-01 13:13:13
        '批次号
        batch_no = Request.Form("WIDbatch_no")
        '必填，格式：当天日期[8位]+序列号[3至24位]，如：201008010000001
        '退款笔数
        batch_num = Request.Form("WIDbatch_num")
        '必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）
        '退款详细数据
        detail_data = Request.Form("WIDdetail_data")
        '必填，具体格式请参见接口技术文档

'/////////////////////请求参数/////////////////////

'构造请求参数数组
sParaTemp = Array("service=refund_fastpay_by_platform_pwd","partner="&partner,"_input_charset="&input_charset  ,"notify_url="&notify_url   ,"seller_email="&seller_email   ,"refund_date="&refund_date   ,"batch_no="&batch_no   ,"batch_num="&batch_num   ,"detail_data="&detail_data  )

'建立请求
Set objSubmit = New AlipaySubmit
sHtml = objSubmit.BuildRequestForm(sParaTemp, "get", "确认")
response.Write sHtml


%>
</body>
</html>
