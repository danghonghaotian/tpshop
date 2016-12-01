<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<title>myzoom</title>
</head>
<body>
	<div id="preview">
        <div class="jqzoom" id="spec-n1">
        	<img src="./images/sku49954/thumbnail/300x/sku49954_1.jpg" jqimg="./images/sku49954/thumbnail/600x/sku49954_1.jpg"/>
        </div>
        <div id="spec-n5">
          <div class="control" id="spec-left">
            <a href="javascript:;"></a>
          </div>
          <div id="spec-list">
            <ul class="list-h">
              <li class="active" style="margin-left: 15px;"><img data-smallimg="./images/sku49954/thumbnail/300x/sku49954_1.jpg" data-bigimg="./images/sku49954/thumbnail/600x/sku49954_1.jpg" src="./images/sku49954/thumbnail/100x/sku49954_1.jpg"> </li>
              <li><img data-smallimg="./images/sku49954/thumbnail/300x/sku49954_2.jpg" data-bigimg="./images/sku49954/thumbnail/600x/sku49954_2.jpg" src="./images/sku49954/thumbnail/100x/sku49954_2.jpg"> </li>
			  <li><img data-smallimg="./images/sku49954/thumbnail/300x/sku49954_3.jpg" data-bigimg="./images/sku49954/thumbnail/600x/sku49954_3.jpg" src="./images/sku49954/thumbnail/100x/sku49954_3.jpg"> </li>
			  <li><img data-smallimg="./images/sku49954/thumbnail/300x/sku49954_4.jpg" data-bigimg="./images/sku49954/thumbnail/600x/sku49954_4.jpg" src="./images/sku49954/thumbnail/100x/sku49954_4.jpg"> </li>
			  <li><img data-smallimg="./images/sku49954/thumbnail/300x/sku49954_5.jpg" data-bigimg="./images/sku49954/thumbnail/600x/sku49954_5.jpg" src="./images/sku49954/thumbnail/100x/sku49954_5.jpg"> </li>
            </ul>
            <div class="clear"></div>
          </div>
          <div class="control" id="spec-right">
            <a href="javascript:;"></a>
          </div>
        </div>
     </div>

<script type="text/javascript" src="js/lib.js"></script>
<script type="text/javascript">

    $(function(){     
       $(".jqzoom").jqueryzoom({
        xzoom:425,
        yzoom:425,
        offset:10,
        position:"right",
        preload:1,
        lens:1
      });

      function ScrollImg(mainObj, leftBtn, rightBtn, Width, PageSize) {
        /*动态切换方法*/
        var Num = 0;
        var Page = 1;
        var Page2 = $(mainObj).children().size();
        //缩略图左右按钮点击切换
        $(leftBtn).click(function () {
            if (Num > 0) {
                Num--;
                scrollImg(Num);
                ChageButton(Num);
            }
        });
        $(rightBtn).click(function () {
            if (Num < (Page2 - Page * PageSize)) {
                Num++;
                scrollImg(Num);
                ChageButton(Num);
            }
        });
        if (Page2 > PageSize) {
            $(rightBtn).addClass("select");
        }
        //左右小按钮的状态
        function ChageButton(Num) {
            if (Num <= 0) {
                $(leftBtn).removeClass("select");
            } else {
                $(leftBtn).addClass("select");
            }
            if (Num >= Page2 - Page * PageSize) {
                $(rightBtn).removeClass("select");
            } else {
                $(rightBtn).addClass("select");
            }
        }
        function scrollImg(Num) {
            $(mainObj).animate({ marginLeft: "-" + Num * Width + "px" }, 200);
        }
    }
    ScrollImg(".list-h", "#spec-left", "#spec-right", 96, 4);
      $("#spec-list img").mouseover(function(){
    	var smallimg = $(this).data('smallimg');
    	var bigimg = $(this).data('bigimg');
    	$('#spec-n1').find('img').attr('src',smallimg);
    	$('#spec-n1').find('img').attr('jqimg',bigimg);
		$(this).parent().addClass('active');
		$(this).parent().siblings().removeClass('active');
      });       
    })
    

  </script>
</body>
</html>