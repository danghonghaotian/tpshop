var kdniao={
	init:function(){
		/*加载样式表*/
		var url='/plugins/kdniao/skin/kdniao.css?'+new Date().getTime();
		var link = document.createElement("link");
		link.rel = "stylesheet";
		link.type = "text/css";
		link.href = url;
		document.getElementsByTagName("head")[0].appendChild(link);
		var csstype="flo";
		/*
		fix 固定  flo 浮动
		默认浮动,不需要在页面添加容器
		使用固定的方式在页面容器中指定class="fix"
		*/
		var cont=$("#queryContext");
		if(cont.length<1)
		{
			$(document.body).append('<div id="queryContext" class="'+csstype+'"></div>'); 
			cont=$("#queryContext");
		}
		if($("#queryContextbg").length<1)
		{
			$(document.body).append('<div id="queryContextbg"></div>'); 
		}
		cont.hide();
		$("#queryContextbg").hide();
	},
	query:function(num,wltype){
		var shtml="";
		var cont=$("#queryContext");
		if(cont.length<1)
		{
			$(document.body).append('<div id="queryContext"></div>'); 
			cont=$("#queryContext");
		}
		if(num.length<1||wltype.length<1)
		{
			shtml='快递单号或者物流类型为空';
			retrun;
		}
		$.post('/plugins/kdniao/kdniao_post.php'
			, {nu:num,com:wltype}, 
			function(result){
				result=eval('(' + result + ')');
				var shtml='<div class="header"><div class="th"><h2>物流轨迹</h2><span>'+wltype+':'+num+'</span>';
				if(cont.attr("class")=="flo"){
					shtml+='<a class="close" href="#" onclick="kdniao.close()"></a>';
				}
				shtml+='</div></div><div class="tbody">';
				if(!result.Success)
				{
					shtml+='<div class="errmsg">';
					shtml+=result.Reason;
					shtml+='，请登录快递鸟 www.kdniao.com,联系技术支持</div>';
				}else{
					if(result.Traces.length==0){
						shtml+='<div class="errmsg">单号暂无轨迹，请<a href="#" onclick="kdniao.query("'+num+'","'+wltype+'")">刷新重试</a></div>';
					}else{
						shtml+='<table class="kd_tb"><thead><tr><th class="th" colspan="4"></th></tr></thead><tbody>';
						var curdata,tardata,tartime;
						for(var i=0;i<result.Traces.length;i++)
						{
							tardata=new Date(result.Traces[i].AcceptTime.replace(/-/g,"/")).Format('yyyy-MM-dd');
							tartime=new Date(result.Traces[i].AcceptTime.replace(/-/g,"/")).Format('hh:MM:ss');
							switch(i)
							{
								case 0:
									shtml+='<tr><td class="td1"><b class="fir"/></td>';
								break;
								case result.Traces.length-1:
									shtml+='<tr><td class="td1"><b class="end"/></td>';
								break;
								default:
									shtml+='<tr><td class="td1"><b class="mid"/></td>';
								break;
							}
							if(i==result.Traces.length-1){
								shtml+='<td class="cur td2">';
							}else{
								shtml+='<td>';
							}
							if(curdata!=tardata){
								curdata=tardata;
								shtml+=curdata+'</td>';
							}
							else{
								shtml+='</td>';
							}
							if(i==result.Traces.length-1){
								shtml+='<td class="cur td3">'+tartime+'</td><td class="cur td4">'+result.Traces[i].AcceptStation+'</td></tr>';
							}else{
								shtml+='<td class="td3">'+tartime+'</td><td class="td4">'+result.Traces[i].AcceptStation+'</td></tr>';
							}

						}
						shtml+='</tbody></table>';
					}
				}
				shtml+='</div>';
				shtml+='<div class="footer"><div class="info"><a class="cp" href="http://www.kdniao.com" target="_blank">快递鸟</a>提供数据支持(以上信息由物流公司提供，如无跟踪信息或有疑问，请咨询对应的物流公司)</div></div>';
				cont.html(shtml);
				$("#queryContext").show();
				if(cont.attr("class")=="flo")
					$("#queryContextbg").show();
				else
					$("#queryContextbg").hide();
			});
	},
	close:function(){
		$("#queryContext").hide();
		$("#queryContextbg").hide();
	}
};
kdniao.init();


//---------------------------------------------------  
// 日期格式化  
// 格式 YYYY/yyyy/YY/yy 表示年份  
// MM/M 月份  
// W/w 星期  
// dd/DD/d/D 日期  
// hh/HH/h/H 时间  
// mm/m 分钟  
// ss/SS/s/S 秒  
//---------------------------------------------------  
Date.prototype.Format = function(formatStr)   
{   
    var str = formatStr;   
    var Week = ['日','一','二','三','四','五','六'];  
  
    str=str.replace(/yyyy|YYYY/,this.getFullYear());   
    str=str.replace(/yy|YY/,(this.getYear() % 100)>9?(this.getYear() % 100).toString():'0' + (this.getYear() % 100));   
  
    str=str.replace(/MM/,this.getMonth()>9?this.getMonth().toString():'0' + this.getMonth());   
    str=str.replace(/M/g,this.getMonth());   
  
    str=str.replace(/w|W/g,Week[this.getDay()]);   
  
    str=str.replace(/dd|DD/,this.getDate()>9?this.getDate().toString():'0' + this.getDate());   
    str=str.replace(/d|D/g,this.getDate());   
  
    str=str.replace(/hh|HH/,this.getHours()>9?this.getHours().toString():'0' + this.getHours());   
    str=str.replace(/h|H/g,this.getHours());   
    str=str.replace(/mm/,this.getMinutes()>9?this.getMinutes().toString():'0' + this.getMinutes());   
    str=str.replace(/m/g,this.getMinutes());   
  
    str=str.replace(/ss|SS/,this.getSeconds()>9?this.getSeconds().toString():'0' + this.getSeconds());   
    str=str.replace(/s|S/g,this.getSeconds());   
  
    return str;   
}   