<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/9/20
 * Time: 13:38
 */

namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller
{

    /**
     * 如果没有安装，这跳转到安装模块
     * 如果是手机访问，则跳转到手机模块
     */
    public function __construct()
    {
        // 必须先调用父类的构造函数
        parent::__construct();
        if(!IS_AJAX)
        {
            if(TPSIsMobile())
            {
                $this->redirect('Mobile/index/index');
            }
            else //给模板的公共部分赋值
            {
                //全部分类数据
                $goodsModel = D('Goods');
                $categoryModel = M('Category');
                $category = $categoryModel ->select();
                $cateAll = $goodsModel->getChildArr($category);
                $this->assign('cateAll',$cateAll);

                //中间导航栏的数据
                $navModel = D('Nav');
                $middleNav = $navModel->where(array('position'=>'middle','is_show'=>1))->order('view_order asc')->select();
                $this->assign('middleNav',$middleNav);

                //底部导航栏
                $bottomNav = $navModel->where(array('position'=>'bottom','is_show'=>1))->order('view_order asc')->select();
                $this->assign('bottomNav',$bottomNav);

                //顶部导航栏
                $topNav = $navModel->where(array('position'=>'top','is_show'=>1))->order('view_order asc')->select();
                $this->assign('topNav',$topNav);

                //历史记录
                $goodsHistory = $goodsModel->getGoodsListHistory();
                $this->assign('goodsHistory',$goodsHistory);


                //底部帮助信息
                // 购物保障5
                $articleModel = M('Article');
                $shop_help = $articleModel->field(array('article_id','title'))->where(array('cat_id'=>5))->select();
                $this->assign('shop_help',$shop_help);

                //配送方式
                $delivery = $articleModel->field(array('article_id','title'))->where(array('cat_id'=>8))->select();
                $this->assign('delivery',$delivery);
            }
        }

    }
}