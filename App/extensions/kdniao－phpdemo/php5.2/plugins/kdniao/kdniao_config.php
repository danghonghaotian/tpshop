<?php
/*
快递鸟申请地址：http://www.kdniao.com/ServiceApply.aspx
生产环境地址：http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx
*/
//快递鸟申请的商户ID
defined('EBusinessID') or define('EBusinessID', '1256299');
//电商加密私钥，快递鸟提供，注意保管，不要泄漏
defined('AppKey') or define('AppKey', '691e792f-0e03-4550-b43e-c26940dcfff7');
//请求url
defined('ReqURL') or define('ReqURL', 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx');

/*
提示：如果您需要的公司不在以下列表，请按以下方法自行添加或修改，快递公司名称区分大小写
case "与后台配置的物流公司名称一致":
$postcom '中的名称与【http://www.kdniao.com/file/ExpressCode.xls】下的【快递公司代码】一致’;
*/
switch ($getcom){
	case "EMS"://后台中显示的快递公司名称
		$postcom = 'ems';//快递公司代码
		break;
	case "中通速递":
		$postcom= 'zto';
		break;
	case "7天连锁物流":
		$postcom= '7TLSWL';
		break;
	case "安捷快递":
		$postcom= 'AJ';
		break;
	case "安能物流":
		$postcom= 'ANE';
		break;
	case "安信达快递":
		$postcom= 'AXD';
		break;
	case "巴伦支快递":
		$postcom= 'BALUNZHI';
		break;
	case "百福东方":
		$postcom= 'BFDF';
		break;
	case "宝凯物流":
		$postcom= 'BKWL';
		break;
	case "北青小红帽":
		$postcom= 'BQXHM';
		break;
	case "邦送物流":
		$postcom= 'BSWL';
		break;
	case "百世物流":
		$postcom= 'BTWL';
		break;
	case "CCES快递":
		$postcom= 'CCES';
		break;
	case "城市100":
		$postcom= 'CITY100';
		break;
	case "COE东方快递":
		$postcom= 'COE';
		break;
	case "长沙创一":
		$postcom= 'CSCY';
		break;
	case "传喜物流":
		$postcom= 'CXWL';
		break;
	case "德邦":
		$postcom= 'DBL';
		break;
	case "德创物流":
		$postcom= 'DCWL';
		break;
	case "东红物流":
		$postcom= 'DHWL';
		break;
	case "D速物流":
		$postcom= 'DSWL';
		break;
	case "店通快递":
		$postcom= 'DTKD';
		break;
	case "大田物流":
		$postcom= 'DTWL';
		break;
	case "大洋物流快递":
		$postcom= 'DYWL';
		break;
	case "快捷速递":
		$postcom= 'FAST';
		break;
	case "飞豹快递":
		$postcom= 'FBKD';
		break;
	case "FedEx联邦快递":
		$postcom= 'FEDEX';
		break;
	case "飞狐快递":
		$postcom= 'FHKD';
		break;
	case "飞康达":
		$postcom= 'FKD';
		break;
	case "飞远配送":
		$postcom= 'FYPS';
		break;
	case "凡宇速递":
		$postcom= 'FYSD';
		break;
	case "广东邮政":
		$postcom= 'GDEMS';
		break;
	case "冠达快递":
		$postcom= 'GDKD';
		break;
	case "挂号信":
		$postcom= 'GHX';
		break;
	case "港快速递":
		$postcom= 'GKSD';
		break;
	case "共速达":
		$postcom= 'GSD';
		break;
	case "广通速递":
		$postcom= 'GTKD';
		break;
	case "国通快递":
		$postcom= 'GTO';
		break;
	case "高铁速递":
		$postcom= 'GTSD';
		break;
	case "河北建华":
		$postcom= 'HBJH';
		break;
	case "汇丰物流":
		$postcom= 'HFWL';
		break;
	case "华航快递":
		$postcom= 'HHKD';
		break;
	case "天天快递":
		$postcom= 'HHTT';
		break;
	case "韩润物流":
		$postcom= 'HLKD';
		break;
	case "恒路物流":
		$postcom= 'HLWL';
		break;
	case "黄马甲快递":
		$postcom= 'HMJKD';
		break;
	case "海盟速递":
		$postcom= 'HMSD';
		break;
	case "天地华宇":
		$postcom= 'HOAU';
		break;
	case "华强物流":
		$postcom= 'hq568';
		break;
	case "华企快运":
		$postcom= 'HQKY';
		break;
	case "昊盛物流":
		$postcom= 'HSWL';
		break;
	case "百世汇通":
		$postcom= 'HTKY';
		break;
	case "户通物流":
		$postcom= 'HTWL';
		break;
	case "华夏龙物流":
		$postcom= 'HXLWL';
		break;
	case "好来运快递":
		$postcom= 'HYLSD';
		break;
	case "京东快递":
		$postcom= 'JD';
		break;
	case "京广速递":
		$postcom= 'JGSD';
		break;
	case "九曳供应链":
		$postcom= 'JIUYE';
		break;
	case "佳吉快运":
		$postcom= 'JJKY';
		break;
	case "嘉里大通":
		$postcom= 'JLDT';
		break;
	case "捷特快递":
		$postcom= 'JTKD';
		break;
	case "急先达":
		$postcom= 'JXD';
		break;
	case "晋越快递":
		$postcom= 'JYKD';
		break;
	case "加运美":
		$postcom= 'JYM';
		break;
	case "久易快递":
		$postcom= 'JYSD';
		break;
	case "佳怡物流":
		$postcom= 'JYWL';
		break;
	case "康力物流":
		$postcom= 'KLWL';
		break;
	case "快淘快递":
		$postcom= 'KTKD';
		break;
	case "快优达速递":
		$postcom= 'KYDSD';
		break;
	case "跨越速递":
		$postcom= 'KYWL';
		break;
	case "龙邦快递":
		$postcom= 'LB';
		break;
	case "联邦快递":
		$postcom= 'LBKD';
		break;
	case "蓝弧快递":
		$postcom= 'LHKD';
		break;
	case "联昊通速递":
		$postcom= 'LHT';
		break;
	case "乐捷递":
		$postcom= 'LJD';
		break;
	case "立即送":
		$postcom= 'LJS';
		break;
	case "民邦速递":
		$postcom= 'MB';
		break;
	case "门对门":
		$postcom= 'MDM';
		break;
	case "民航快递":
		$postcom= 'MHKD';
		break;
	case "明亮物流":
		$postcom= 'MLWL';
		break;
	case "闽盛快递":
		$postcom= 'MSKD';
		break;
	case "能达速递":
		$postcom= 'NEDA';
		break;
	case "南京晟邦物流":
		$postcom= 'NJSBWL';
		break;
	case "平安达腾飞快递":
		$postcom= 'PADTF';
		break;
	case "陪行物流":
		$postcom= 'PXWL';
		break;
	case "全晨快递":
		$postcom= 'QCKD';
		break;
	case "全峰快递":
		$postcom= 'QFKD';
		break;
	case "全日通快递":
		$postcom= 'QRT';
		break;
	case "如风达":
		$postcom= 'RFD';
		break;
	case "日昱物流":
		$postcom= 'RLWL';
		break;
	case "赛澳递":
		$postcom= 'SAD';
		break;
	case "圣安物流":
		$postcom= 'SAWL';
		break;
	case "盛邦物流":
		$postcom= 'SBWL';
		break;
	case "山东海红":
		$postcom= 'SDHH';
		break;
	case "上大物流":
		$postcom= 'SDWL';
		break;
	case "顺丰快递":
		$postcom= 'SF';
		break;
	case "盛丰物流":
		$postcom= 'SFWL';
		break;
	case "上海林道货运":
		$postcom= 'SHLDHY';
		break;
	case "盛辉物流":
		$postcom= 'SHWL';
		break;
	case "穗佳物流":
		$postcom= 'SJWL';
		break;
	case "速通物流":
		$postcom= 'ST';
		break;
	case "申通快递":
		$postcom= 'STO';
		break;
	case "三态速递":
		$postcom= 'STSD';
		break;
	case "速尔快递":
		$postcom= 'SURE';
		break;
	case "山西红马甲":
		$postcom= 'SXHMJ';
		break;
	case "沈阳佳惠尔":
		$postcom= 'SYJHE';
		break;
	case "世运快递":
		$postcom= 'SYKD';
		break;
	case "通和天下":
		$postcom= 'THTX';
		break;
	case "唐山申通":
		$postcom= 'TSSTO';
		break;
	case "全一快递":
		$postcom= 'UAPEX';
		break;
	case "优速快递":
		$postcom= 'UC';
		break;
	case "万家物流":
		$postcom= 'WJWL';
		break;
	case "微特派":
		$postcom= 'WTP';
		break;
	case "万象物流":
		$postcom= 'WXWL';
		break;
	case "新邦物流":
		$postcom= 'XBWL';
		break;
	case "信丰快递":
		$postcom= 'XFEX';
		break;
	case "香港邮政":
		$postcom= 'XGYZ';
		break;
	case "祥龙运通":
		$postcom= 'XLYT';
		break;
	case "希优特":
		$postcom= 'XYT';
		break;
	case "源安达快递":
		$postcom= 'YADEX';
		break;
	case "邮必佳":
		$postcom= 'YBJ';
		break;
	case "远成物流":
		$postcom= 'YCWL';
		break;
	case "韵达快递":
		$postcom= 'YD';
		break;
	case "义达国际物流":
		$postcom= 'YDH';
		break;
	case "越丰物流":
		$postcom= 'YFEX';
		break;
	case "原飞航物流":
		$postcom= 'YFHEX';
		break;
	case "亚风快递":
		$postcom= 'YFSD';
		break;
	case "银捷速递":
		$postcom= 'YJSD';
		break;
	case "亿领速运":
		$postcom= 'YLSY';
		break;
	case "英脉物流":
		$postcom= 'YMWL';
		break;
	case "亿顺航":
		$postcom= 'YSH';
		break;
	case "音素快运":
		$postcom= 'YSKY';
		break;
	case "易通达":
		$postcom= 'YTD';
		break;
	case "一统飞鸿":
		$postcom= 'YTFH';
		break;
	case "运通快递":
		$postcom= 'YTKD';
		break;
	case "圆通速递":
		$postcom= 'YTO';
		break;
	case "宇鑫物流":
		$postcom= 'YXWL';
		break;
	case "邮政平邮/小包":
		$postcom= 'YZPY';
		break;
	case "增益快递":
		$postcom= 'ZENY';
		break;
	case "汇强快递":
		$postcom= 'ZHQKD';
		break;
	case "宅急送":
		$postcom= 'ZJS';
		break;
	case "芝麻开门":
		$postcom= 'ZMKM';
		break;
	case "中睿速递":
		$postcom= 'ZRSD';
		break;
	case "众通快递":
		$postcom= 'ZTE';
		break;
	case "中铁快运":
		$postcom= 'ZTKY';
		break;
	case "中铁物流":
		$postcom= 'ZTWL';
		break;
	case "中天万运":
		$postcom= 'ZTWY';
		break;
	case "中外运速递":
		$postcom= 'ZWYSD';
		break;
	case "中邮物流":
		$postcom= 'ZYWL';
		break;
	case "郑州建华":
		$postcom= 'ZZJH';
		break;
	default:
		$postcom = '';
}