<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/22
 * Time: 15:18
 * 系统配置项目
 */
namespace Admin\Controller;
use Think\Controller;

class ConfigController extends AdminController
{
    public function save()
    {
        if(IS_POST)
        {
            $model = D('Config');
            // 插入数据库
            if($model->add() !== FALSE)
            {
                $this->success('更新成功');
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
        $model = D('Config');
        $data = $model->select();
        foreach ($data as $k=>$v)
        {
            $this->assign($v['key'],$v['value']);
        }
        $this->display();
    }



}