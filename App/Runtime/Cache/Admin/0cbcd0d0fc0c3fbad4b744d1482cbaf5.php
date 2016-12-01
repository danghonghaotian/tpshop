<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo C('shopName');?> - 添加短信 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
<link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/Sms/lst") ?>">短信列表</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> - 添加短信 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="<?php echo U("Admin/Sms/add") ?>" method="post" name="sms" >
        <table width="100%" id="general-table">
            <tr>
                <td class="label">订单号:</td>
                <td>
                    <input type='text' name='ordernumber' maxlength="20" value='' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">手机号:</td>
                <td>
                    <input type='text' name='phonenumber' maxlength="20" value='' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">发送状态:</td>
                <td>
                   <select name="status">
                       <?php foreach ($status as $k=>$v): ?>
                       <option value="<?php echo $k;?>"><?php echo $v;?></option>
                       <?php endforeach; ?>
                   </select>
                </td>
            </tr>
            <tr>
                <td class="label">发送类型:</td>
                <td>
                    <select name="sendtype">
                        <?php foreach ($sendtype as $k=>$v): ?>
                            <option value="<?php echo $k;?>"><?php echo $v;?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">发送内容:</td>
                <td>
                    <textarea rows="10" cols="60" name="content"></textarea> <font color="red">*</font>
                </td>
            </tr>



        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>
<?php include_once "/assets/template/footer.php";?>
</body>
</html>