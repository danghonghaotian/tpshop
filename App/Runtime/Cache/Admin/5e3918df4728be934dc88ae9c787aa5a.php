<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 商品品牌 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo C('js');?>/jquery.js"></script>
    <style type="text/css">
        /*first-cell做相对定位，这边做绝对定位*/
        .brand_thumb{display: none; position: absolute;z-index: 3;left: 60px;}
    </style>
    <script type="text/javascript">
        //鼠标滑过显示品牌图片的动态效果
        $(function () {
            $('.first-cell').hover(function () {
               $(this).find('img').show();
            },function () {
                $(this).find('img').hide();
            });
        })
   </script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/Brand/add")?>">添加商品品牌</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index")?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> -商品品牌 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="<?php echo C('img');?>/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <input type="text" name="brand_name" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>品牌名称</th>
                <th>品牌网址</th>
                <th>品牌描述</th>
                <th>排序</th>
                <th>是否显示</th>
                <th>操作</th>
            </tr>
            <?php foreach ($brand as $k=>$v):?>
            <tr>
                <td class="first-cell">
                    <?php echo $v['brand_name'];?>
                    <img src="<?php echo $v['brand_thumb'];?>" class="brand_thumb"/>
                </td>
                <td align="left">
                    <a href="<?php echo $v['site_url'];?>" target="_brank"><?php echo $v['site_url'];?></a>
                </td>
                <td align="left"><?php echo $v['brand_desc'];?></td>
                <td align="center"><?php echo $v['sort_order'];?></td>
                <td align="center"><?php echo $showData[$v['is_show']];?></td>
                <td align="center">
                    <a href="<?php echo U("Admin/Brand/save",array('brand_id'=>$v['brand_id']))?>" title="编辑">编辑</a> |
                    <a  onclick="return confirm('确定要删除吗');" href="<?php echo U("Admin/Brand/delete",array('brand_id'=>$v['brand_id']))?>" title="删除">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td align="right" nowrap="true" colspan="6">
                    <?php echo $page;?>
                </td>
            </tr>
        </table>
    </div>

<?php include_once "/assets/template/footer.php";?>
</body>
</html>