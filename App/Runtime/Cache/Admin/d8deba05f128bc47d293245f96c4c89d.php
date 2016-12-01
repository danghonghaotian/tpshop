<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 修改品牌 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/Brand/lst") ?>">品牌列表</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index") ?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> - 修改品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U("Admin/Brand/save") ?>" enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">品牌名称</td>
                <td>
                    <input type="text" name="brand_name" maxlength="60" value="<?php echo $brandData['brand_name'];?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">品牌网址</td>
                <td>
                    <input type="text" name="site_url" maxlength="60" size="40" value="<?php echo $brandData['site_url'];?>" />
                </td>
            </tr>
            <tr>
                <td class="label">品牌LOGO</td>
                <td>
                    <img src="<?php echo $brandData['brand_thumb'];?>" />
                    <input type="file" name="brand_logo" id="logo" size="45" value="<?php echo $brandData['brand_thumb'];?>"><br/>
                    <span class="notice-span" style="display:block"  id="warn_brandlogo">如果不传图片代表不修改图片</span>
                </td>
            </tr>
            <tr>
                <td class="label">品牌描述</td>
                <td>
                    <textarea  name="brand_desc" cols="60" rows="4"  ><?php echo $brandData['brand_desc'];?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort_order" maxlength="40" size="15" value="<?php echo $brandData['sort_order'];?>" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" name="is_show" value="1"
                           <?php if($brandData['is_show'] ==1):?>
                               checked="checked"
                           <?php endif;?>
                     /> 是
                    <input type="radio" name="is_show"
                        <?php if($brandData['is_show'] ==0):?>
                            checked="checked"
                        <?php endif;?>
                           value="0"  /> 否(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
            <input type="hidden" name="brand_id" value="<?php echo $brandData['brand_id'];?>" />
        </table>
    </form>
</div>
<?php include_once "/assets/template/footer.php";?>
</body>
</html>