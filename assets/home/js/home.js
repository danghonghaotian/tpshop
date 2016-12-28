/*
 * 跃飞科技版权所有 @2016
 */

/*
@功能：订单页面js,帮助中心js
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


    //帮助中心js start hyLi
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
  //帮助中心js end


  });
})(jQuery)