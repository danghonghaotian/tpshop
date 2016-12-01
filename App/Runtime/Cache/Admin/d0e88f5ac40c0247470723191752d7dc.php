<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 商品分类 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
    <link type="text/css" href="<?php echo C('css');?>/jquery.tbltree.css" rel="stylesheet">
    <script src="<?php echo C('js');?>/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo C('js');?>/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo C('js');?>/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo C('js');?>/jquery.tbltree.js"></script>
    <script src="<?php echo C('js');?>/scale.fix.js"></script>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script>
        $(function() {
            $( "#category" ).tbltree({
                treeColumn: 0,
                saveState: true
            });
        });
    </script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/Category/add")?>">添加商品分类</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index")?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> -商品分类 </span>
    <div style="clear:both"></div>
</h1>
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" id="category">
            <tr>
                <th>分类名称</th>
                <th>操作</th>
            </tr>
            <?php foreach ($categoryData as $k=>$v):?>
            <tr row-id="<?php echo $v['id'];?>" <?php if($v['parent_id']):?> parent-id="<?php echo $v['parent_id'] ?>" <?php endif;?> >
                <td class="first-cell">
                    <?php echo $v['cat_name'];?>
                </td>
                <td align="center">
                    <a href="<?php echo U("Admin/Category/save",array('id'=>$v['id']))?>" title="编辑">编辑</a> |
                    <a onclick="return confirm('确定要删除吗,删除分类的同时会删除该分类下的所有商品');"  href="<?php echo U("Admin/Category/delete",array('id'=>$v['id']))?>" title="删除">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>

<?php include_once "/assets/template/footer.php";?>
</body>
</html>