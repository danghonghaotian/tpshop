CSS代码：

.out_box{border:1px solid #ccc; background:#fff; font:12px/20px Tahoma;}
.list_box{border-bottom:1px solid #eee; padding:0 5px; cursor:pointer;}
.focus_box{background:#f0f3f9;}
.mark_box{color:#c00;}

HTML代码：

<p>自定义class展示：<input type="text" id="customTest" size="28" /></p>

JS代码：

$("#customTest").mailAutoComplete({
    boxClass: "out_box", //外部box样式
    listClass: "list_box", //默认的列表样式
    focusClass: "focus_box", //列表选样式中
    markCalss: "mark_box", //高亮样式
    autoClass: false,
    textHint: true, //提示文字自动隐藏
    hintText: "请输入邮箱地址"
});

http://www.zhangxinxu.com/wordpress/2010/06/%E6%96%87%E6%9C%AC%E6%A1%86%E9%82%AE%E7%AE%B1%E5%9C%B0%E5%9D%80%E8%87%AA%E5%8A%A8%E6%8F%90%E7%A4%BAjquery%E6%8F%92%E4%BB%B6/