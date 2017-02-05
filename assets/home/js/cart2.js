/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
$(function(){
	//收货人修改
	// $("#address_modify").click(function(){
	// 	$(this).hide();
	// 	$(".address_info").hide();
	// 	$(".address_select").show();
	// });
    //
	// $(".new_address").click(function(){
	// 	$("form[name=address_form]").show();
	// 	$(this).parent().addClass("cur").siblings().removeClass("cur");
    //
	// }).parent().siblings().find("input").click(function(){
	// 	$("form[name=address_form]").hide();
	// 	$(this).parent().addClass("cur").siblings().removeClass("cur");
	// });
    //
	// //送货方式修改
	// $("#delivery_modify").click(function(){
	// 	$(this).hide();
	// 	$(".delivery_info").hide();
	// 	$(".delivery_select").show();
	// })

	$("input[name=delivery]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//支付方式修改
	$("#pay_modify").click(function(){
		$(this).hide();
		$(".pay_info").hide();
		$(".pay_select").show();
	})

	$("input[name=pay_id]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//发票信息修改
	$("#receipt_modify").click(function(){
		$(this).hide();
		$(".receipt_info").hide();
		$(".receipt_select").show();
	})

	$(".company").click(function(){
		$(".company_input").removeAttr("disabled");
	});

	$(".personal").click(function(){
		$(".company_input").attr("disabled","disabled");
	});


	//配送至
	$("input[name=address_id]").eq(0).click(function(){
		var consignee = $(this).data('consignee');
		var address = $(this).data('address');
		var tel = $(this).data('tel');
		var delivery = '寄送至： '+address+'　收货人：'+consignee+' '+tel;
		$('.consignee').html(delivery);
		$(this).parent().addClass("cur").siblings().removeClass("cur");
	}).trigger('click'); //自动触发选中默认

	$("input[name=address_id]").click(function(){
		var consignee = $(this).data('consignee');
		var address = $(this).data('address');
		var tel = $(this).data('tel');
		var delivery = '寄送至： '+address+'　收货人：'+consignee+' '+tel;
		$('.consignee').html(delivery);
		$(this).parent().addClass("cur").siblings().removeClass("cur");
	});


});