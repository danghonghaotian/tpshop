<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/6
 * Time: 16:10
 * 配送方式
 */

namespace Admin\Controller;
use Think\Controller;

class ShippingController extends AdminController
{
    public function lst()
    {
        $shippingModel =  D('Shipping');
        $shipping = $shippingModel->search();
//        dump($shipping);
        $this->assign('shipping', $shipping['data']);
        $this->assign('page', $shipping['page']);
        $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $model = D('Shipping');
            // 接收并验证表单
            if($model->create())
            {
                // 插入数据库
                if($model->add() !== FALSE)
                {
                    $this->success('添加成功', U('lst'));
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql().' - ERROR:'.mysql_error();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());  // 输出表单验证失败的原因
        }
        $this->display();
    }

    public function delete($id)
    {
        $shippingModel = M('Shipping');
        $shippingModel->delete($id);
        $this->success('删除成功');
    }


    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Shipping');
            if($model->create())
            {
                if($model->save() !== FALSE)
                {
                    $this->success('修改成功', U('lst'));
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());
        }

        // 取出要修改的记录
        $model = D('Shipping');
        $data = $model->find($id);
        $this->assign('data', $data);
        $this->display();
    }

}