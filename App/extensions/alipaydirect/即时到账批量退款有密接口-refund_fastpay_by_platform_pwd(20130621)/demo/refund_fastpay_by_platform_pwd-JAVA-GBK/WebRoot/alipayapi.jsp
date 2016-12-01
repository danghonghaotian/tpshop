<%
/* *
 *功能：即时到账批量退款有密接口接入页
 *版本：3.3
 *日期：2012-08-14
 *说明：
 *以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 *该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*****************
 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 *1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 *2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 *3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 *如果不想使用扩展功能请把扩展功能参数赋空值。
 **********************************************
 */
%>
<%@ page language="java" contentType="text/html; charset=gbk" pageEncoding="gbk"%>
<%@ page import="com.alipay.config.*"%>
<%@ page import="com.alipay.util.*"%>
<%@ page import="java.util.HashMap"%>
<%@ page import="java.util.Map"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gbk">
		<title>支付宝即时到账批量退款有密接口</title>
	</head>
	<%
		////////////////////////////////////请求参数//////////////////////////////////////

		//服务器异步通知页面路径
		String notify_url = "http://www.xxx.com/refund_fastpay_by_platform_pwd-JAVA-GBK/notify_url.jsp";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数
		//卖家支付宝帐户
		String seller_email = new String(request.getParameter("WIDseller_email").getBytes("ISO-8859-1"),"GBK");
		//必填
		//退款当天日期
		String refund_date = new String(request.getParameter("WIDrefund_date").getBytes("ISO-8859-1"),"GBK");
		//必填，格式：年[4位]-月[2位]-日[2位] 小时[2位 24小时制]:分[2位]:秒[2位]，如：2007-10-01 13:13:13
		//批次号
		String batch_no = new String(request.getParameter("WIDbatch_no").getBytes("ISO-8859-1"),"GBK");
		//必填，格式：当天日期[8位]+序列号[3至24位]，如：201008010000001
		//退款笔数
		String batch_num = new String(request.getParameter("WIDbatch_num").getBytes("ISO-8859-1"),"GBK");
		//必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）
		//退款详细数据
		String detail_data = new String(request.getParameter("WIDdetail_data").getBytes("ISO-8859-1"),"GBK");
		//必填，具体格式请参见接口技术文档
		
		
		//////////////////////////////////////////////////////////////////////////////////
		
		//把请求参数打包成数组
		Map<String, String> sParaTemp = new HashMap<String, String>();
		sParaTemp.put("service", "refund_fastpay_by_platform_pwd");
        sParaTemp.put("partner", AlipayConfig.partner);
        sParaTemp.put("_input_charset", AlipayConfig.input_charset);
		sParaTemp.put("notify_url", notify_url);
		sParaTemp.put("seller_email", seller_email);
		sParaTemp.put("refund_date", refund_date);
		sParaTemp.put("batch_no", batch_no);
		sParaTemp.put("batch_num", batch_num);
		sParaTemp.put("detail_data", detail_data);
		
		//建立请求
		String sHtmlText = AlipaySubmit.buildRequest(sParaTemp,"get","确认");
		out.println(sHtmlText);
	%>
	<body>
	</body>
</html>
