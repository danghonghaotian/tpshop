<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 添加属性 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/Attribute/lst",array('type_id'=>$_GET['type_id'])) ?>">属性列表</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> - 添加属性 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U("Admin/Attribute/add") ?>" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">属性名称</td>
                <td>
                    <input type="text" name="attr_name" maxlength="60" value="" size="60"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">所属商品类型</td>
                <td>
                    <select name="goods_type_id">
                        <option value="">请选择..</option>
                        <?php foreach ($goodsTypeData as $k=>$v): ?>
                            <option
                                <?php if($goodsData['id'] == $v['id']): ?>
                                    selected = "selected"
                                <?php endif;?>
                                value="<?php echo $v['id'];?>"><?php echo $v['type_name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">属性类型</td>
                <td>
                    <input type="radio" name="attr_type" value="0" checked="checked" /> 唯一
                    <input type="radio" name="attr_type" value="1" /> 单选
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">属性可选的值</td>
                <td>
                    <textarea rows="6" cols="60" name="attr_value"></textarea>
                    <span class="require-field">如果有多个值用，号隔开。</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include_once "/assets/template/footer.php";?>
</body>
</html>