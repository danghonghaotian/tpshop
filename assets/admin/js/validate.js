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


});
