<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 修改管理员 </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/AdminMember/lst") ?>">管理员列表</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> - 修改管理员 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U("Admin/AdminMember/save") ?>"enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">管理员名称</td>
                <td>
                    <input type="text" name="username" maxlength="60" size="40" value="<?php echo $adminMemberData['username']?>" readonly="readonly" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">密码</td>
                <td>
                    <input type="text" name="password" maxlength="60" size="40" value="" />
                    <span class="require-field">*为空，则不修改密码</span>
                </td>
            </tr>
            <tr>
                <td class="label">角色选择</td>
                <td>
                    <?php foreach ($roleData as $k=>$v): ?>
                    <input type="checkbox" name="role_id[]" value="<?php echo $v['id'];?>"
                        <?php if(in_array($v['id'],$role_id )):?>
                            checked="checked"
                        <?php endif;?>
                        /><?php echo $v['name'];?>(<?php echo $v['remark'];?>)
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo $adminMemberData['id']?>" />
    </form>
</div>
<?php include_once "/assets/template/footer.php";?>
</body>
</html>