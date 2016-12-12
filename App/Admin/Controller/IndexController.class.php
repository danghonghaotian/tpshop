<?php
/**
 * 跃飞科技版权所有 @2016
 */

/**
 * User: 钟贵廷
 * Date: 2016/7/26
 * Time: 11:51
 */
namespace Admin\Controller;


use Think\Controller;

class IndexController extends  AdminController
{
    public function index()
    {
//        var_dump(session('privilege'));
        $this->display();
    }

    public function top()
    {
        $this->display();
    }

    public function menu()
    {
        $this->display();
    }

    public function main()
    {
        $this->display();
    }

    /**
     * 清空缓存
     */
    public function clearCache()
    {
        $goodsModel = D('Goods');
        $dir = C('ROOT_PATH').'/App/Runtime/Cache';
        $goodsModel->clearPic($dir);
        $dir2 = C('ROOT_PATH').'/App/Runtime/Temp';
        $goodsModel->clearPic($dir2);
        $this->success('清理成功',U('Admin/Index/main'));
    }

}