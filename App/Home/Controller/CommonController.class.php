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