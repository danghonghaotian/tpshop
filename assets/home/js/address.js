/*
 * 跃飞科技版权所有 @2017
 * Created by 钟贵廷 on 2017/2/4.
 */

$(function () {
    //省份改变
    $('#province').change(function(){
        var provinceId = $(this).val();
        $.ajax({
            type: "POST",
            url: "/index.php/Home/Address/ajaxGetCity",
            data: {provinceId:provinceId},
            success: function(msg){
                //删除大于0的选项
                $('#city').find('option:gt(0)').remove();
                $('#area').find('option:gt(0)').remove();
                if(msg != '')
                {
                    //返回的省份数据插入到省份选项
                    var cityData = $.parseJSON(msg);
                    var str = '';
                    $.each(cityData,function(i,city){
                        str+='<option value="'+city.region_id+'">'+city.region_name+'</option>'
                    });
                    $('#city').append(str);
                }
            }
        });
    });
    //城市改变
    $('#city').change(function(){
        var cityId = $(this).val();
        $.ajax({
            type: "POST",
            url: "/index.php/Home/Address/ajaxGetArea",
            data: {cityId:cityId},
            success: function(msg){

                //删除大于0的选项
                $('#area').find('option:gt(0)').remove();
                if(msg != '')
                {
                    //返回的县城数据插入到县城选项
                    var townData = $.parseJSON(msg);
                    var str = '';
                    $.each(townData,function(i,town){
                        str+='<option value="'+town.region_id+'">'+town.region_name+'</option>'
                    });
                    $('#area').append(str);
                }
            }
        });
    });
});