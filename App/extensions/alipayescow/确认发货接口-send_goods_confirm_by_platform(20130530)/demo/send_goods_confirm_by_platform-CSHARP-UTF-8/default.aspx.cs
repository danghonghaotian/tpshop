using System;
using System.Data;
using System.Configuration;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using System.Collections.Generic;
using System.Text;
using System.IO;
using System.Xml;
using Com.Alipay;

/// <summary>
/// 功能：确认发货接口接入页
/// 版本：3.3
/// 日期：2012-07-05
/// 说明：
/// 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
/// 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
/// 
/// /////////////////注意///////////////////////////////////////////////////////////////
/// 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
/// 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
/// 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
/// 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
/// 
/// 如果不想使用扩展功能请把扩展功能参数赋空值。
/// </summary>
public partial class _Default : System.Web.UI.Page 
{
    protected void Page_Load(object sender, EventArgs e)
    {
    }

    protected void BtnAlipay_Click(object sender, EventArgs e)
    {
        ////////////////////////////////////////////请求参数////////////////////////////////////////////

        //支付宝交易号
        string trade_no = WIDtrade_no.Text.Trim();
        //必填
        //物流公司名称
        string logistics_name = WIDlogistics_name.Text.Trim();
        //必填
        //物流发货单号
        string invoice_no = WIDinvoice_no.Text.Trim();
        //物流运输类型
        string transport_type = WIDtransport_type.Text.Trim();
        //三个值可选：POST（平邮）、EXPRESS（快递）、EMS（EMS）


        ////////////////////////////////////////////////////////////////////////////////////////////////

        //把请求参数打包成数组
        SortedDictionary<string, string> sParaTemp = new SortedDictionary<string, string>();
        sParaTemp.Add("partner", Config.Partner);
        sParaTemp.Add("_input_charset", Config.Input_charset.ToLower());
        sParaTemp.Add("service", "send_goods_confirm_by_platform");
        sParaTemp.Add("trade_no", trade_no);
        sParaTemp.Add("logistics_name", logistics_name);
        sParaTemp.Add("invoice_no", invoice_no);
        sParaTemp.Add("transport_type", transport_type);

        //建立请求
        string sHtmlText = Submit.BuildRequest(sParaTemp);

        //请在这里加上商户的业务逻辑程序代码

        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

        XmlDocument xmlDoc = new XmlDocument();
        try
        {
            xmlDoc.LoadXml(sHtmlText);
            string strXmlResponse = xmlDoc.SelectSingleNode("/alipay").InnerText;
            Response.Write(strXmlResponse);
        }
        catch (Exception exp)
        {
            Response.Write(sHtmlText);
        }

        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
    }
}
