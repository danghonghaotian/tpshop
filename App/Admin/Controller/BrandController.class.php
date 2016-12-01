<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/8/26
 * Time: 15:52
 */
namespace Admin\Controller;
use Think\Controller;
class BrandController extends AdminController
{
    /**
     * 品牌列表
     */
    public function lst()
    {
        $brandModel = D('Brand');
        //是否显示
        $showData = $brandModel->getShow();
        $this->assign('showData', $showData);
        //显示列表
        $data = $brandModel -> search();
        $this->assign('brand', $data['data']);
        $this->assign('page', $data['page']);
        $this->display();
    }

    /**
     * 添加品牌
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Brand');
            // 接收并验证表单
            if($model->create())
            {
                // 上传品牌的图片
                $msg = $model->upload();
                //提示上传失败信息
                if($msg !== true)
                {
                    $this->error($msg);
                }
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
        $this ->display();
    }


    /**
     * 修改品牌
     * @param $brand_id
     */
    public function save($brand_id)
    {
        if(IS_POST)
        {
            $model = D('Brand');
            if($model->create())
            {
                // 上传品牌的图片
                $model->upload();
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

        $brandModel = D('Brand');
        $brandData = $brandModel->find($brand_id);
        $this->assign('brandData',$brandData);
        $this ->display();
    }

    /**
     * 这里考虑到是品牌，不删除图片服务器上的图片
     * 如果该品牌下商品不能删除
     * @param $brand_id
     */
    public function delete($brand_id)
    {
        $brandModel = M('Brand');
        $brandData = $brandModel->find($brand_id);
        if(!empty($brandData))
        {
            $brandModel->delete($brand_id);
            $this->success("删除成功！");
        }
        else
        {
            $this->error('手贱，没有该品牌');
        }
    }
}