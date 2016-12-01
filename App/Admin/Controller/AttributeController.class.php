<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/18
 * Time: 16:21
 */

namespace Admin\Controller;
use Think\Controller;
class AttributeController extends AdminController
{
    public function lst($type_id = 0)
    {
         $attributeModel = D('Attribute');
        //如果type_id为0，表示搜索所有属性
        if($type_id == 0)
        {
            $attributeData =  $attributeModel->select();
        }
        else
        {
            $attributeData =  $attributeModel->where(array('goods_type_id'=>$type_id))->select();
        }
        $goodsTypeModel = D('GoodsType');
        $goodsTypeData = $goodsTypeModel->getType();
        $this->assign('goodsTypeData',$goodsTypeData);
        $this->assign('attributeData',$attributeData);

        $goodsType = $goodsTypeModel->select();
        $this->assign('goodsType',$goodsType);

        $this->display();
    }

    public function add($type_id =null)
    {
        if(IS_POST)
        {
            $model = D('Attribute');
            // 接收并验证表单
            if($model->create())
            {
                // 插入数据库
                if($model->add() !== FALSE)
                {
                    $this->success('添加成功', U('lst', array('type_id'=>$_POST['goods_type_id'])));
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

        $goodsTypeModel =  D('GoodsType');
        $goodsData =  $goodsTypeModel->find($type_id);
        $goodsTypeData = $goodsTypeModel->select();
        $this->assign('goodsTypeData',$goodsTypeData);
        $this->assign('goodsData',$goodsData);
        $this->display();
    }

    /**
     * 修改商品属性
     * @param $id
     */
    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Attribute');
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
        $model = D('Attribute');
        $data = $model->find($id);
        $this->assign('data', $data);
        $goodsTypeModel = D('GoodsType');
        $goodsTypeData = $goodsTypeModel->select();
        $this->assign('goodsTypeData',$goodsTypeData);
        $this->display();
    }

    /**
     * 删除属性
     * @param $id
     */
    public function delete($id)
    {
        $model = D('Attribute');
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