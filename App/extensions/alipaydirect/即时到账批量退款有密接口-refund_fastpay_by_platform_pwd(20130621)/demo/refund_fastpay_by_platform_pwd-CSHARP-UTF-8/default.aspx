<%@ Page Language="C#" AutoEventWireup="true" CodeFile="default.aspx.cs" Inherits="_Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <title>支付宝即时到账批量退款有密接口</title>
    <style>
*{
	margin:0;
	padding:0;
}
ul,ol{
	list-style:none;
}
.title{
    color: #ADADAD;
    font-size: 14px;
    font-weight: bold;
    padding: 8px 16px 5px 10px;
}
.hidden{
	display:none;
}

.new-btn-login-sp{
	border:1px solid #D74C00;
	padding:1px;
	display:inline-block;
}

.new-btn-login{
    background-color: transparent;
    background-image: url("images/new-btn-fixed.png");
    border: medium none;
}
.new-btn-login{
    background-position: 0 -198px;
    width: 82px;
	color: #FFFFFF;
    font-weight: bold;
    height: 28px;
    line-height: 28px;
    padding: 0 10px 3px;
}
.new-btn-login:hover{
	background-position: 0 -167px;
	width: 82px;
	color: #FFFFFF;
    font-weight: bold;
    height: 28px;
    line-height: 28px;
    padding: 0 10px 3px;
}
.bank-list{
	overflow:hidden;
	margin-top:5px;
}
.bank-list li{
	float:left;
	width:153px;
	margin-bottom:5px;
}

#main{
	width:750px;
	margin:0 auto;
	font-size:14px;
	font-family:'宋体';
}
#logo{
	background-color: transparent;
    background-image: url("images/new-btn-fixed.png");
    border: medium none;
	background-position:0 0;
	width:166px;
	height:35px;
    float:left;
}
.red-star{
	color:#f00;
	width:10px;
	display:inline-block;
}
.null-star{
	color:#fff;
}
.content{
	margin-top:5px;
}

.content dt{
	width:160px;
	display:inline-block;
	text-align:right;
	float:left;
	
}
.content dd{
	margin-left:100px;
	margin-bottom:5px;
}
#foot{
	margin-top:10px;
}
.foot-ul li {
	text-align:center;
}
.note-help {
    color: #999999;
    font-size: 12px;
    line-height: 130%;
    padding-left: 3px;
}

.cashier-nav {
    font-size: 14px;
    margin: 15px 0 10px;
    text-align: left;
    height:30px;
    border-bottom:solid 2px #CFD2D7;
}
.cashier-nav ol li {
    float: left;
}
.cashier-nav li.current {
    color: #AB4400;
    font-weight: bold;
}
.cashier-nav li.last {
    clear:right;
}
.alipay_link {
    text-align:right;
}
.alipay_link a:link{
    text-decoration:none;
    color:#8D8D8D;
}
.alipay_link a:visited{
    text-decoration:none;
    color:#8D8D8D;
}
</style>
</head>
<body>
    <form id="Form1" runat="server">
        <div id="main">
            <div id="head">
                <dl class="alipay_link">
                    <a target="_blank" href="http://www.alipay.com/"><span>支付宝首页</span></a>| <a target="_blank"
                        href="https://b.alipay.com/home.htm"><span>商家服务</span></a>| <a target="_blank" href="http://help.alipay.com/support/index_sh.htm">
                            <span>帮助中心</span></a>
                </dl>
                <span class="title">支付宝即时到账批量退款有密接口快速通道</span>
            </div>
            <div class="cashier-nav">
                <ol>
                    <li class="current">1、确认信息 →</li>
                    <li>2、点击确认 →</li>
                    <li class="last">3、确认完成</li>
                </ol>
            </div>
            <div id="body" style="clear: left">
                <dl class="content">
                    <dt>卖家支付宝帐户：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <asp:TextBox ID="WIDseller_email" name="WIDseller_email" runat="server"></asp:TextBox>
                        <span>必填</span>
                    </dd>
                    <dt>退款当天日期：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <asp:TextBox ID="WIDrefund_date" name="WIDrefund_date" runat="server"></asp:TextBox>
                        <span>必填，格式：年[4位]-月[2位]-日[2位] 小时[2位 24小时制]:分[2位]:秒[2位]，如：2007-10-01 13:13:13</span>
                    </dd>
                    <dt>批次号：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <asp:TextBox ID="WIDbatch_no" name="WIDbatch_no" runat="server"></asp:TextBox>
                        <span>必填，格式：当天日期[8位]+序列号[3至24位]，如：201008010000001</span>
                    </dd>
                    <dt>退款笔数：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <asp:TextBox ID="WIDbatch_num" name="WIDbatch_num" runat="server"></asp:TextBox>
                        <span>必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）</span>
                    </dd>
                    <dt>退款详细数据：</dt>
                    <dd>
                        <span class="null-star">*</span>
                        <asp:TextBox ID="WIDdetail_data" name="WIDdetail_data" runat="server"></asp:TextBox>
                        <span>必填，具体格式请参见接口技术文档</span>
                    </dd>
                    <dt></dt>
                    <dd>
                        <span class="new-btn-login-sp">
                            <asp:Button ID="BtnAlipay" name="BtnAlipay" class="new-btn-login" Text="确 认" Style="text-align: center;"
                                runat="server" OnClick="BtnAlipay_Click"/></span></dd></dl>
            </div>
            <div id="foot">
                <ul class="foot-ul">
                    <li><font class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。 </font></li>
                    <li>支付宝版权所有 2011-2015 ALIPAY.COM </li>
                </ul>
                <ul>
            </div>
        </div>
    </form>
</body>
</html>