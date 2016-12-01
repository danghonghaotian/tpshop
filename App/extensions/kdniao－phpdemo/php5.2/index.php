<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>快递鸟查询插件测试页面</title>
	<script type="text/javascript" src="/plugins/kdniao/jquery.min.js"></script>
	<script type="text/javascript" src="/plugins/kdniao/kdniao.js"></script>
</head>
<body>
	<a href="#" onclick="kdniao.query('778692162447','中通速递')">点击查询</a>
	<!--采用浮动的方式，可添加 class="flo"-->
</body>
<script type="text/javascript">
	$(function(){
		kdniao.init();
		//如果使用页面自动加载，需要在页面加载中调用以下函数
		//kdniao.query("778692162447","中通速递");
	});
</script>
</html>