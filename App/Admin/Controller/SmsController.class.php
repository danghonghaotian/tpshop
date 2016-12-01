<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/7/26
 * Time: 14:52
 */

namespace Admin\Controller;


use Think\Controller;

class SmsController extends AdminController
{
    /**
     * 短信列表
     */
    public function lst()
    {
        $sms = D('Sms');
        $fieldName = $sms->fieldName();
        $this->assign('fieldName',$fieldName);
        $data = $sms->search(array("trash"=>0));
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->assign('status',$sms->getStatus());
        $this->assign('sendtype',$sms->getSendType());
        $this->display();
    }

    /**
     * 添加短信
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Sms');
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

        $sms = D('Sms');
        $status = $sms->getStatus();
        $sendType = $sms->getSendType();
        $this->assign("status",$status);
        $this->assign("sendtype",$sendType);
        $this->display();


    }

    /**
     * 更改短信
     * @param $id
     */
    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Sms');
            if($model->create())
            {
                $model->sms_id = $id;
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
        $sms = D('Sms');
        $data = $sms->find($id);
        $this->assign('data', $data);
        $status = $sms->getStatus();
        $sendType = $sms->getSendType();
        $this->assign("status",$status);
        $this->assign("sendtype",$sendType);
        $fieldName = $sms->fieldName();
        $this->assign('fieldName',$fieldName);
        $this->display();
    }

    /**
     * 删除短信
     */
   public function del($id)
   {
       $sms = M("sms");
       $sms->delete($id);
       $this->success('删除成功！');
   }

    /**
     * 批量删除短信
     * I('post.name','','htmlspecialchars'); 获取$_POST['name']
     */
    public function batchDel()
    {
        $sms = M("sms");
        if(I('post.sms_id'))
        {
            $idArr = I('post.sms_id');
            $ids = implode(',',$idArr );
            $sms->delete($ids);
            $this->success('批量删除成功！');
        }
    }

    /**
     * 短信回收
     */
    public function trash($id)
    {
        $sms = M('sms');
        $sms->where(array('sms_id'=>$id))->setField('trash',1);
        $this->success("已放到回收站");
    }

    /**
     * 还原短信
     * @param $id
     */
    public function recovery($id)
    {
        $sms = M('sms');
        $sms->where(array('sms_id'=>$id))->setField('trash',0);
        $this->success("短信已还原");
    }

    /**
     * 批量恢复短信
     */
    public function batchRecovery()
    {
        if(I('post.sms_id'))
        {
           $idArr =  I('post.sms_id');
           $ids = implode(',',$idArr );
           $sms = M('sms');
           $sms->where(array('sms_id'=>array('in',$ids)))->save(array('trash'=>0));
           $this->success("批量恢复短信成功！");
        }
    }

    /**
     * 回收站列表页
     */
    public function trashList()
    {
        $sms = D('Sms');
        $fieldName = $sms->fieldName();
        $this->assign('fieldName',$fieldName);
        $data = $sms->search(array("trash"=>1));
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->assign('status',$sms->getStatus());
        $this->assign('sendtype',$sms->getSendType());
        $this->display();
    }

    /**
     * 根据条件搜索
     */
    public function search()
    {
        $send_type = I("send_type");
        $sms = D('Sms');
        $fieldName = $sms->fieldName();
        $this->assign('fieldName',$fieldName);
        $data = $sms->search(array("sendtype"=>$send_type));
        $this->assign('data', $data['data']);
        $this->assign('page', $data['page']);
        $this->assign('status',$sms->getStatus());
        $this->assign('sendtype',$sms->getSendType());
        $this->display('lst');
    }


}