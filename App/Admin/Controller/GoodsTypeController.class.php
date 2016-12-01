<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/16
 * Time: 13:31
 */
namespace Admin\Controller;
use Think\Controller;

class GoodsTypeController extends AdminController
{
    public function lst()
    {
        $model = D('GoodsType');
        $data = $model->search();
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $model = D('GoodsType');
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

    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('GoodsType');
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
        $model = D('GoodsType');
        $data = $model->find($id);
        $this->assign('data', $data);
        // 显示表单
        $this->display();
    }

    /**
     * 删除商品类型
     * 数据表做了innodb设计，删除类型的同时，相关的属性会删除
     * @param $id
     */
    public function delete($id)
    {
        $model = D('GoodsType');
        $data = $model->find($id);
        if(empty($data))
        {
            $this->error('手贱，剁手');
        }
        else
        {
            $model->delete($id);
            $this->success('删除成功！');
        }
    }
}