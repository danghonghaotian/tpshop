/*
@功能：订单页面js
@作者：diamondwang
@时间：2013年11月15日
*/
/*$(function(){
	
})*/

(function($){
  $(function(){
    //左侧菜单收缩效果
    $(".menu_wrap dt").click(function(){
      $(this).siblings().toggle();
      $(this).find("b").toggleClass("off");
    });


    $(".left-nav").find("dt").click(function(){
      if($(this).next("dd").is(":visible")){
        $(this).next("dd").slideUp("200");
        $(this).find("em").removeClass("on")
      }else{
        $(".left-nav").find("dd").slideUp("200");
        $(this).next("dd").slideDown("200");
        $(".left-nav dt").find("em").removeClass("on");
        $(this).find("em").addClass("on");
      }
    })

    $(".left-nav dd").find("a").click(function(){
      $(".left-nav dd").find("a").removeClass("on");
      $(this).addClass("on");
    })

    $(".left-nav dt").click(function(){
      $(".left-nav").find("dt").find("span").removeClass("spcli");
      $(this).find("span").addClass("spcli");
    })

   var initialObj = $(".left-nav dd a").siblings(".on");
   $(".left-nav dd").addClass("hide");
   $(".left-nav dt").find("em").removeClass("on").end().find("span").removeClass("spcli");
   initialObj.parent("dd").removeClass("hide").siblings("dt").find("em").addClass("on").end().find("span").addClass("spcli");
   
  });
})(jQuery)