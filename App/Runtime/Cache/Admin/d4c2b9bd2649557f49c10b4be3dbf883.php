<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 修改角色 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/Role/lst") ?>">角色列表</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> - 修改角色 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U("Admin/Role/save") ?>">
<input type="hidden" name="id" value="<?php echo $role_data['id']; ?>">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名称</td>
                <td>
                    <input type="text" name="name" maxlength="60" value="<?php echo $role_data['name']?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">角色描述</td>
                <td>
                    <textarea  name="remark" cols="60" rows="4"  ><?php echo $role_data['remark']?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label">使用状态</td>
                <td>
                    <input type="radio" name="status" value="1"
                           <?php if($role_data['status'] == 1):?>
                           checked="checked"
                           <?php endif;?>
                    /> 开启
                    <input type="radio" name="status" value="0"
                        <?php if($role_data['status'] == 0):?>
                            checked="checked"
                        <?php endif;?>
                    /> 关闭
                </td>
            </tr>
        </table>

        <table cellspacing="1" cellpadding="3" width="100%">
            <?php foreach ($node_data as $k=>$v):?>
            <tr>
                <td class="label" style="font-weight: bold;color: red">
                    <input name="node_id[]" value="<?php echo $v['id'];?>" type="checkbox"
                    <?php if(in_array($v['id'],$node_arr )):?>
                        checked = checked;
                    <?php endif;?>
                    /><?php echo $v['title']?></td>
                <td></td>
            </tr>
            <?php foreach ($v['child'] as $k1=>$v1):?>
            <tr>
                <td class="label">
                    <input name="node_id[]" value="<?php echo $v1['id'];?>" type="checkbox"
                    <?php if(in_array($v1['id'],$node_arr )):?>
                        checked = checked;
                    <?php endif;?>
                    ><?php echo $v1['title']; ?> </td>
                <td>
                    <?php foreach ($v1['child'] as $k2=>$v2): ?>
                    <div style="width:200px;float:left;">
                        <label for="goods_manage">
                            <input name="node_id[]" value="<?php echo $v2['id'];?>"  type="checkbox"
                                <?php if(in_array($v2['id'],$node_arr )):?>
                                    checked = checked;
                                <?php endif;?>
                            />
                            <?php echo $v2['title']; ?>
                        </label>
                    </div>
                    <?php endforeach;?>
                </td>
            </tr>
            <?php endforeach;?>
            <?php endforeach;?>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " class="button"/>
            <input type="reset" value=" 重置 " class="button" />
        </div>
    </form>
</div>
<?php include_once "/assets/template/footer.php";?>
</body>
</html>