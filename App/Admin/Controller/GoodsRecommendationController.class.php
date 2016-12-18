<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/18
 * Time: 21:58
 */

namespace Admin\Controller;
use Think\Controller;

class GoodsRecommendationController extends AdminController
{

    public function lst()
    {
        $model = D('GoodsRecommendation');
        $type = $model->getType();
        $this->assign('type', $type);
        $data = $model->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $model = D('GoodsRecommendation');
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
        $model = D('GoodsRecommendation');
        $type = $model->getType();
        $this->assign('type', $type);
        $this->display();
    }


    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('GoodsRecommendation');
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
        $goodsRecommendationModel =  D('GoodsRecommendation');
        $goodsRecommendation = $goodsRecommendationModel->find($id);
        $this->assign('goodsRecommendation',$goodsRecommendation);
        $type =  $goodsRecommendationModel->getType();
        $this->assign('type', $type);
        $this->display();
    }


}