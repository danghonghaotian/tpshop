<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/21
 * Time: 15:48
 */
namespace Admin\Controller;
use Think\Controller;

class ActivityController extends AdminController
{
    public function lst($keyword = '')
    {
        $activityModel = D('Activity');
        $data = $activityModel -> search(trim($keyword));
        $this->assign('activity', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }


    public function add()
    {
        if(IS_POST)
        {
            $model = D('Activity');
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
            $model = D('Activity');
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
        $activityModel = D('Activity');
        $data =  $activityModel->find($id);
        $this->assign('data', $data);

        $this->display();
    }

    /**
     * 删除
     * @param $id
     */
    public function delete($id)
    {
        //先找出图片删除
        $activityModel = D('Activity');
        $activityModel->delete($id);
        $this->success('删除成功');
    }
}