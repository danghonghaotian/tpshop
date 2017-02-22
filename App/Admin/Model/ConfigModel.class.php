<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/22
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class ConfigModel extends Model
{
    /**
     * 更改之前先清空数据表里面的数据
     */
    public function add()
    {
        $prefix = C('DB_PREFIX');
        $sql = "TRUNCATE table {$prefix}config";
        $this->execute($sql);
        $arr = array();
        foreach ($_POST as $k=>$v)
        {
            $arr['key'] = $k;
            $arr['value'] = $v;
            parent::add($arr);
        }
        return true;
    }

    /*设置数据库配置*/
    public function setConfig()
    {
        $data = $this->select();
        foreach ($data as $k=>$v)
        {
           C($v['key'],$v['value']);
        }
    }
}