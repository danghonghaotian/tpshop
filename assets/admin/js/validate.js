/**
 *  on 2016/12/20.
 *  钟贵廷
 */

$(function () {

    //广告管理验证
    $("#adForm").validate({
        rules: {
            ad_name: "required",
            adpos_id: "required",
            ad_url: "required",
            start_time: "required",
            end_time: "required",
        },
        messages: {
            ad_name: "广告名称必须",
            adpos_id: "广告显示位置必须",
            ad_url: "广告链接",
            start_time: "开始时间必须",
            end_time: "结束时间必须",
        }
    });


});
