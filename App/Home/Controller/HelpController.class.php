<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/28
 * Time: 10:37
 */

namespace Home\Controller;
use Think\Controller;
class HelpController extends CommonController
{
    /**
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('404,该页面不存在',U('Home/Index/index'),1);
    }

    public function lst()
    {
        $articleModel  = D('Article');
        $helpInfo = $articleModel-> getArticleInfo();

        $data = $articleModel->find(I('get.id'));

        //面包屑
        $articleCatModel  = M('ArticleCat');
        $articleCat = $articleCatModel->select();
        $articleCat =  $articleModel->getAllParentCatByCatId($articleCat,$data['cat_id']);
        array_shift($articleCat); //不需要系统分类

        $this->assign('helpInfo', $helpInfo);
        $this->assign('article', $data);
        $this->assign('articleCat', $articleCat);
        $this->display();
    }
}