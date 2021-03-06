/**
 *  on 2016/12/20.
 *  钟贵廷
 */


$(function () {

    //校验比较时间方法
    $.validator.methods.compareDate = function() {
        var start_time = $("#start_time").val();
        var end_time = $("#end_time").val();
        var reg = new RegExp('-','g');
        start_time = start_time.replace(reg,'/');//正则替换
        deadlinetime = end_time.replace(reg,'/');
        start_time = new Date(parseInt(Date.parse(start_time),10));
        end_time = new Date(parseInt(Date.parse(end_time),10));
        if(start_time>end_time)
        {
            return false;
        }
        else
        {
            return true;
        }
    };

    //广告管理验证
    $("#adForm").validate({
        // 失去鼠标焦点就验证
        // onfocusout: function(element){
        //     $(element).valid();
        // },
        onfocusin: function(element){
            $(element).valid();
        },

        rules: {
            ad_name: "required",
            adpos_id: "required",
            ad_url: "required",
            start_time: "required",
            end_time: {
                "required":true,
                compareDate: "#start_time"
            }
        },
        messages: {
            ad_name: "广告名称不能为空",
            adpos_id: "广告显示位置不能为空",
            ad_url: "广告链接不能为空",
            start_time: "开始时间不能为空",
            end_time:{
                required: "结束时间不能为空",
                compareDate: "结束日期必须大于开始日期!"
            }
        }
    });


    //商品管理验证
    $("#goodsForm").validate({
        onfocusin: function(element){
            $(element).valid();
        },

        rules: {
            'goods[goods_name]': "required",
            'goods[goods_sn]': "required",
            'goods[cat_id]': "required",
            'goods[brand_id]': "required",
            'goods[goods_number]': "required",
            'goods[market_price]': "required",
            'goods[shop_price]': "required",
            'goods[weight]': "required",
            'goods[is_on_sale]': "required",
            'goods[no_postage]': "required",
        },
        messages: {
            'goods[goods_name]': "商品名称不能为空",
            'goods[goods_sn]': "商品sku不能为空",
            'goods[cat_id]': "请选择商品分类",
            'goods[brand_id]': "请选择商品品牌",
            'goods[goods_number]': "商品数量不能为空",
            'goods[market_price]': "市场价不能为空",
            'goods[shop_price]': "本店价不能为空",
            'goods[weight]': "重量不能为空",
            'goods[is_on_sale]': "请选择是否上架",
            'goods[no_postage]': "请选择是否包邮",
        }
    });


    //客服管理验证
    $("#onlineForm").validate({
        onfocusin: function(element){
            $(element).valid();
        },

        rules: {
            'onlinename': "required",
            'qq': "required",
            'weixin': "required",
            'taobao': "required",

        },
        messages: {
            'onlinename': "客服名称不能为空",
            'qq': "qq账号不能为空",
            'weixin': "微信账号不能为空",
            'taobao': "淘宝账号不能为空",
        }
    });


    //客服管理验证
    $("#teamCatForm").validate({
        onfocusin: function(element)
        {
            $(element).valid();
        },

        rules: {
            'cat_name': "required",
        },
        messages: {
            'cat_name': "团队分类名称不能为空",
        }
    });

});
