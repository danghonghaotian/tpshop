<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>跳转提示</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css')?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css')?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?> </a> </span><span id="search_id" class="action-span1"> - 系统信息  </span>
    <div style="clear:both"></div>
</h1>
<div class="list-div">
    <div style="background:#FFF; padding: 20px 50px; margin: 2px;">
        <table align="center" width="400">
            <tr>
                <td width="50" valign="top">
                    <?php if(isset($message)):?>
                    <img src="<?php echo C('img')?>/succ.gif" width="32" height="32" border="0" alt="成功" />
                    <?php else:?>
                    <img src="<?php echo C('img')?>/error.gif" width="32" height="32" border="0" alt="失败" />
                    <?php endif;?>
                </td>

                <?php if(isset($message)):?>
                <td style="font-size: 14px; font-weight: bold;color: green"><?php echo $message;?></td>
                <?php else:?>
                <td style="font-size: 14px; font-weight: bold;color: red"><?php echo $error;?></td>
                <?php endif;?>
            </tr>
            <tr>
                <td></td>
                <td id="redirectionMsg">
                    页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait" style="color: red"><?php echo($waitSecond); ?></b>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php include_once "/assets/template/footer.php";?>
</div>

<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>

</body>
</html>