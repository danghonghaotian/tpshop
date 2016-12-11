<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/11
 * Time: 17:08
 */

namespace Admin\Controller;
use Think\Controller;

class NavController extends AdminController
{
    /**
     * 导航栏列表
     */
    public function lst()
    {
        $navModel =  D('Nav');
        $data =  $navModel->search();
        $position = $navModel->getPosition();
        $this->assign('position',$position);
        $nav = $data["data"];
        $page = $data['page'];//分页
        $this->assign('nav',$nav);
        $this->assign('page',$page);
       $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $model = D('Nav');
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
            $model = D('Nav');
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
        $navModel =  D('Nav');
        $nav = $navModel->find($id);
        $this->assign('nav',$nav);
        $position = $navModel->getPosition();
        $this->assign('position',$position);
        $this->display();
    }


    public function delete($id)
    {
        $nav = M("Nav");
        $nav->delete($id);
        $this->success('删除成功！');
    }





}