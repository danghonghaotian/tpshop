/**
 *  on 2016/12/20.
 *  钟贵廷
 */


$(function () {

    //校验密码是否一致
    $.validator.methods.comparePwd = function() {
        var password = $("#password").val();
        var re_password = $("#re_password").val();
        if(password != re_password)
        {
            return false;
        }
        else
        {
            return true;
        }
    };

    /**
     *异步检测验证码
     */
    $.validator.addMethod("checkCode",function(value){
       var flag = false;
        if(value.length == 4) //只有四位的验证码才去校验
        {
            $.ajax({
                type: "POST",
                url:'/index.php/Home/User/ajaxCheckCode',
                data:{code:value},
                async :false,
                success: function(msg) {
                    if(msg)
                    {
                        flag =  true;
                    }
                    else
                    {
                        flag =  false;
                    }
                }
            });
        }
        return flag;
    });

    /**
     * 校验邮箱是否已经被注册
     */
    $.validator.addMethod("checkEmail",function(value){
        var flag = false;
        if(is_email(value)) //只有是邮箱格式才去验证
        {
            $.ajax({
                type: "POST",
                url:'/index.php/Home/User/ajaxCheckEmail',
                data:{email:value},
                async :false,
                success: function(msg) {
                    if(msg)
                    {
                        flag =  true;
                    }
                    else
                    {
                        flag =  false;
                    }
                }
            });
        }
        return flag;
    });

    //邮箱格式
    function is_email(email) {
        var emailReg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if(emailReg.test(email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 判断是否有正确的邮箱
     */
    $.validator.addMethod("isEmail",function(value){
        return is_email(value);
    });


    //用户注册
    $("#registerForm").validate({
        // onfocusin: function(element){
        //     $(element).valid();
        // },

        rules: {
            email: {
                "required":true,
                isEmail:true,
                checkEmail:true,
            },
            password:{
                "required":true,
                "minlength":6,
                "maxlength":20,
            },

            re_password:{
                "required":true,
                comparePwd: "#password"
            },
            verify:{
                "required":true,
                checkCode:true,
            }

        },

        messages: {
            email: {
                "required":"电子邮箱不能为空",
                isEmail:"电子邮箱格式不正确",
                checkEmail:"该邮箱已经被注册，请换一个"
            },
            password:{
                "required":"密码不能为空",
                "minlength":"密码长度不能小于6位",
                "maxlength":"密码长度大于20位",
            },
            re_password:{
                "required":"确认密码不能为空",
                comparePwd: "确认密码不一致!"
            },
            verify:{
                "required":"验证码不正确",
                checkCode:"验证码不正确",
            }

        }
    });


   

});
