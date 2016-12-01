<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/11/30
 * Time: 10:24
 */
namespace Admin\Controller;
use Think\Controller;

class UserRankController extends AdminController
{
    public function lst()
    {
        $userRankModel =  D('UserRank');
        $data =  $userRankModel->search();
        $userRankData = $data["data"];
        $page = $data['page'];//分页
        $this->assign("userRankData", $userRankData);
        $this->assign("page",$page);
        $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $model = D('UserRank');
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
            $model = D('UserRank');
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
        $userRankModel = D('UserRank');
        $userRankData = $userRankModel -> find($id);
        $this -> assign('userRankData',$userRankData);
        $this->display();
    }

    public function delete($id)
    {
        $model = D('UserRank');
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