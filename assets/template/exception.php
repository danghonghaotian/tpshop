<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>系统发生错误</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css')?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css')?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="javascript:history.back(-1)">返回</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> - 异常信息 </span>
    <div style="clear:both"></div>
</h1>
<div class="list-div">
    <div style="background:#FFF; padding: 20px 50px; margin: 2px;">
        <table align="center" width="400">
            <tr>
                <td width="50" valign="top">
                    <img src="<?php echo C('img')?>/error.gif" width="32" height="32" border="0" alt="失败" />
                </td>
                <td style="font-size: 14px; font-weight: bold;color: red"><?php echo strip_tags($e['message']);?></td>
            </tr>
            <?php if(isset($e['file'])):?>
            <tr>
                <td></td>
                <td style="color: darkred; font-size: 14px;font-weight: bold">错误位置:</td>
            </tr>
            <tr>
                <td></td>
                <td style="color: grey">
                    <p>FILE: <?php echo $e['file'] ;?> &#12288;LINE: <?php echo $e['line'];?></p>
                </td>
            </tr>
            <?php endif;?>

            <?php if(isset($e['trace'])):?>
            <tr>
                <td></td>
                <td style="color: darkred; font-size: 14px;font-weight: bold">TRACE:</td>
            </tr>
            <tr>
                <td></td>
                <td style="color: grey"><?php echo nl2br($e['trace']);?></td>
            </tr>
            <?php endif;?>

        </table>
    </div>
</div>
<?php include_once "/assets/template/footer.php";?>
</div>

</body>
</html>