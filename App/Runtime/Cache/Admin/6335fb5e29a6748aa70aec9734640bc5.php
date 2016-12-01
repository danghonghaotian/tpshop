<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 管理员列表 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/AdminMember/add")?>">添加管理员</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index")?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> -管理员列表 </span>
    <div style="clear:both"></div>
</h1>
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>管理员名称</th>
                <th>所属角色</th>
                <th>加密key</th>
                <th>操作</th>
            </tr>
            <?php foreach ($adminMemberData as $k=>$v): ?>
            <tr>
                <td class="first-cell" align="center">
                    <?php echo $v['username'];?>
                </td>

                <td align="center">
                    <?php foreach ($v['role_id'] as $k1=>$v1):?>
                        <?php
 echo $role_name[$v1]; if($v1 != end($v['role_id'])) { echo "、"; } ?>
                    <?php endforeach;?>
                </td>
                <td align="center">
                    <?php echo $v['salt'];?>
                </td>

                <td align="center">
                    <a href="<?php echo U("Admin/AdminMember/save",array('id'=>$v['id']))?>" title="编辑">编辑</a> |
                    <a  onclick="return confirm('确定要删除吗');"  href="<?php echo U("Admin/AdminMember/delete",array('id'=>$v['id']))?>" title="移除">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
<?php include_once "/assets/template/footer.php";?>
</body>
</html>