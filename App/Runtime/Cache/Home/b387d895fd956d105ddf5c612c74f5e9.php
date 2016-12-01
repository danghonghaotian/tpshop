<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <script type="text/javascript" src="<?php echo C('f-js');?>/jquery-1.8.3.min.js"></script>
    <title>测试图片上传</title>
</head>
<body>
<div class="img-area">
    <img src="<?php echo C('f-img');?>/goods6.jpg" old-src="<?php echo C('f-img');?>/goods6.jpg" style="width: 100px;height: 100px;">
</div>
<input type="file" name="photo" class="upload-img"/>
<script>
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // normal
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // firefox
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // google
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    $('input.upload-img').change(function(){
        str=$(this).val();
        var oldImgUrl = $(this).siblings('.img-area').find('img').attr("old-src");
        if(/\.(?:png|PNG|jpg|JPG|gif|PNG)$/.test(str)){
            var arr=str.split('\\');
            var my=arr[arr.length-1];
            $(this).siblings(".upload-name").empty().append(my);
            var objUrl = getObjectURL(this.files[0]);
            if (objUrl) {
                $(this).siblings('.img-area').find('img').attr("src", objUrl);
            }
            $(this).siblings('.btn-upload').removeClass("error");
        }else{
            str="";
            $(this).val("");
            $(this).siblings('.img-area').find('img').attr("src", oldImgUrl);
            $(".upload-name").empty();
            $(this).siblings('.btn-upload').addClass("error");
        }
    });


</script>

</body>
</html>