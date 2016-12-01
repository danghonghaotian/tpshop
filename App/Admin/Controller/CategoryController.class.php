<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/26
 * Time: 14:23
 */
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends AdminController
{
    /**
     * 商品分类
     */
    public function lst()
    {
        $categoryModel = D('Category');
        $categoryData =  $categoryModel->select();
        $categoryData = $categoryModel ->tree($categoryData);
        $this->assign('categoryData',$categoryData);
        $this->display();
    }

    /**
     * 添加商品分类
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Category');
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
        $categoryModel = D('Category');
        $categoryData =  $categoryModel->select();
        $categoryData = $categoryModel ->tree($categoryData);
        $this->assign('categoryData',$categoryData);
        $this->display();
    }

    /**
     * 删除分类
     * 如果分类下面有子分类，不允许删除该类，提示先删除子类
     * @param $id
     */
    public function delete($id)
    {
        $category = D('Category');
        $data =  $category->select();
        $categoryData =  $category->getAllChildIdByPid($data,$id);
        if(!empty($categoryData))
        {
            $this->error("该类下有子类，先删除子类");
        }
        else
        {
            $category->delete($id);
            $this->success('成功删除该分类以及分类下的商品！');
        }
    }

    /**
     * 修改商品分类
     * @param $id
     */
    public function save($id)
    {
        //修改
        if(IS_POST)
        {
            $model = D('Category');
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
        //下拉信息
        $categoryModel = D('Category');
        $cate = $categoryModel->find($id);
        $this->assign('cate',$cate);
        $categoryData =  $categoryModel->select();
        $categoryData = $categoryModel ->tree($categoryData);
        $this->assign('categoryData',$categoryData);
        $this->display();
    }

}