<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/12
 * Time: 17:20
 */
namespace Admin\Controller;
use Think\Controller;
class NodeController extends AdminController
{
    /**
     * 节点列表
     */
    public function lst()
    {
        $node_model = D('Node');
        $node_data =  $node_model->select();
        $node_data = $node_model->tree($node_data);
        $this->assign('node_data',$node_data);
        $this->display();
    }

    /**
     * 添加节点
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Node');
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
     * 修改节点
     * @param $id
     */
    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Node');
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
        $node_model = D('Node');
        $node_data =  $node_model->find($id);
        $this->assign('node_data',$node_data);
        $this->display();
    }

    /**
     * 删除节点
     * 如果控制器下面还有方法，先删方法
     * @param $id
     */
    public function delete($id)
    {
        $node_model = D('Node');
        $node_data =  $node_model->select();
        $all_id  = $node_model::getAllChildIdByPid($node_data,$id);
        if(empty($all_id))
        {
            $node_model->delete($id);
            $this->success('删除成功');
        }
        else
        {
            $this->error('还有方法呢，先删下面的方法吧');
        }
    }


    public function test()
    {
        $node_model = D('Node');
        $node_data =  $node_model->field('id,title,pid')->select();
        $all_id  = $node_model::getChildArr($node_data);
        var_dump($all_id);
    }


    public function test2()
    {
        $arr = array(MODULE_NAME,CONTROLLER_NAME,ACTION_NAME);
        var_dump($arr);
        $node_model = D('Node');
        $node_data =  $node_model->select();
        $idArr = array(15,33,28,18); //角色拥有的方法节点
//        $accessArr = array();
//       foreach ($idArr as $k=>$v)
//        {
//             $accessArr[] = $node_model->getAllParentNodeById($node_data,$v);
//       }

        $accessArr =  $node_model-> getPrivilegeByNodeId($node_data,$idArr);
        $accessArr[] = array(MODULE_NAME,CONTROLLER_NAME,ACTION_NAME);

        if(in_array($arr,$accessArr ))
        {
            echo '可以访问';
//           ke $this->success('');
        }
        else
        {
            $this->error('无权访问');
        }
        var_dump($accessArr);
        
        
        

    }
}