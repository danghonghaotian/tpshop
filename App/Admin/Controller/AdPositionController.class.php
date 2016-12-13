<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/13
 * Time: 19:36
 */
namespace Admin\Controller;
use Think\Controller;

class AdPositionController extends AdminController
{
    public function lst($keyword = '')
    {
        $adPositionModel =  D('AdPosition');
        $data = $adPositionModel -> search(trim($keyword));
        $this->assign('adPosition', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

    public function add()
    {
        if(IS_POST)
        {
            $model =  D('AdPosition');
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


    /**
     * 更改
     * @param $id
     */
    public function save($id)
    {
        if(IS_POST)
        {
            $model =  D('AdPosition');
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
        $adPosition =  D('AdPosition');
        $data =  $adPosition->find($id);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 删除
     */
    public function del($id)
    {
        $adPosition = M("AdPosition");
        $adPosition->delete($id);
        $this->success('删除成功！');
    }

}
