<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/27
 * Time: 17:48
 */

namespace Home\Controller;
use Think\Controller;
class CartController extends CommonController
{
    /**
     *没有的控制器，直接跳到首页
     */
    public function _empty()
    {
        $this->error('404,该页面不存在',U('Home/Index/index'),1);
    }

    public function add()
    {
        if(IS_POST)
        {
            // 处理一个表单中的属性ID
            $goods_id = (int)$_POST['goods_id'];
            $amount = (int)$_POST['amount'];
            $goods_attr = implode(',', $_POST['goods_attr_id']);
            $cartModel = D('Cart');
            if($cartModel->addToCart($goods_id, $amount, $goods_attr) === FALSE)
                $this->error('购物失败!');
            else
                $this->success("购物成功", U('index'));
        }
    }


    /**
     * 购物车列表
     */
    public function index()
    {
        $cartModel = D('Cart');
        $goods = $cartModel->get();
//        dump($goods);
        $this->assign('goods', $goods);
        $this->display();
    }

    public function flow2()
    {
        $this->display();
    }

    public function flow3()
    {
        $this->display();
    }

    /**
     * 更新购物车数量
     */
    public function ajaxUpdateCartGoodsNumber()
    {
        $goods_id = (int)$_POST['goods_id'];
        $goods_number = (int)$_POST['goods_number'];
        $goods_attr = $_POST['goods_attr'];
        $cartModel = D('Cart');
        if($cartModel->updateGoodsNumber($goods_id, $goods_number, $goods_attr) === FALSE)
            echo 0;
        else
            echo 1;
    }

    /**
     * 删除购物车中的商品
     */
    public function del()
    {
        // 处理一个表单中的属性ID
        $goods_id = (int)$_POST['goods_id'];
        $goods_attr = $_POST['goods_attr'];
        $cartModel = D('Cart');
        $cartModel->del($goods_id, $goods_attr);
    }

}