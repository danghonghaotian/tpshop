<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo C('shopName');?> - 会员等级 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo C('css');?>/general.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo C('css');?>/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U("Admin/UserRank/add")?>">添加会员等级</a></span>
    <span class="action-span1"><a href="<?php echo U("Admin/Index/index")?>"><?php echo C('shopName');?></a></span>
    <span id="search_id" class="action-span1"> -会员等级 </span>
    <div style="clear:both"></div>
</h1>

<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>会员等级名称</th>
                <th>积分下限</th>
                <th>积分上限</th>
                <th>初始折扣率(%)</th>
                <th>操作</th>
            </tr>
            <?php foreach ($userRankData as $k=>$v):?>
            <tr>
                <td class="first-cell" align="center">
                    <?php echo $v['level_name']?>
                </td>
                <td align="center">
                    <?php echo $v['low_num']?>
                </td>
                <td align="center"><?php echo $v['top_num']?></td>
                <td align="center"><?php echo $v['rate']?></td>
                <td align="center">
                    <a href="<?php echo U('Admin/UserRank/save',array('id'=>$v['id']));?>" title="编辑">编辑</a> |
                    <a onclick="return confirm('确定要删除吗');" href="<?php echo U('Admin/UserRank/delete',array('id'=>$v['id']));?>" title="移除">移除</a>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td align="center" nowrap="true" colspan="5">
                    <div id="turn-page">
                        <?php echo $page;?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<?php include_once "/assets/template/footer.php";?>
</body>
</html>