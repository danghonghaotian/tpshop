<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/10
 * Time: 9:23
 */
namespace Admin\Controller;
use Think\Controller;

class ArticleCatController extends AdminController
{
    /**
     * 分类列表
     */
    public function lst()
    {
        $article_cat = D('ArticleCat');
        $data =  $article_cat->select();
        $article_cat_data =  $article_cat->tree($data);
        $cate_type = $article_cat->getCatType();

        $this->assign('article_cat_data', $article_cat_data);
        $this->assign('cat_type', $cate_type);
        $this->display();
    }

    /**
     * 添加分类
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('ArticleCat');
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

        $article_cat = D('ArticleCat');
        $data =  $article_cat->select();
        $article_cat_data =  $article_cat->tree($data);
        $this->assign('article_cat_data', $article_cat_data);
        $cate_type = $article_cat->getCatType();
        $this->assign('cat_type', $cate_type);
        $this->display();
    }

    public  function save($cat_id)
    {
        if(IS_POST)
        {
            $model = D('ArticleCat');
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
        $article_cat_model = D('ArticleCat');
        $article_cat_data  = $article_cat_model->find($cat_id);
        //取出下拉数据
        $data =  $article_cat_model->field("cat_id,cat_name,parent_id")->select();
        $article_cat =  $article_cat_model->tree($data);
        $this->assign('article_cat',$article_cat);
        $this->assign('article_cat_data', $article_cat_data);
        //取出分类类型数据
        $cat_type =  $article_cat_model -> getCatType();
        $this->assign('cat_type', $cat_type);
        $this->display();
    }

    /**
     * 删除分类
     * 如果分类下面有子分类，不允许删除该类，提示先删除子类
     *   2.3,4分类类型不能删除
     *   $cat_type['2'] = '系统分类';
     *   $cat_type['3'] = '网店信息';
      *  $cat_type['4'] = '帮助分类';
     * @param $cat_id
     */
    public function delete($cat_id)
    {
        $article_cat = D('ArticleCat');
        $data =  $article_cat->field('cat_id,cat_name,parent_id')->select();
        $article_cat_data =  $article_cat->getAllSubCatByParentId($data,$cat_id);
        if(!empty($article_cat_data))
        {
            $this->error("该类下有子类，先删除子类");
        }
        else
        {
            $cat_type =  $article_cat->where(array("cat_id"=>$cat_id))->getField('cat_type');
            $arr = array(2,3,4);
            if(in_array($cat_type,$arr ))
            {
                $this->error("系统分类|网店信息|帮助分类分类不能删除，请检查");
            }
            else
            {
                /*分类下有文章不能删除代码*/
//                $article_model = D('Article');
//                $cnt = $article_model->where(array('cat_id'=>$cat_id))->count();
//                if($cnt>0)
//                {
//                    $this->error("该分类下还有文章，不能删除，请检查");
//                }
//                else
//                {
//                    $article_cat ->delete($cat_id);
//                }
                $article_cat ->delete($cat_id);
                //删除该子类下的所有文章
                $article_model = D('Article');
                $article_model->where(array('cat_id'=>$cat_id))->delete();
                $this->success('成功删除该分类以及分类下的文章！');
            }
        }
    }


    public function test()
    {
        $model =  D("ArticleCat");
        $data =  $model->select();
//      $data =  $model->getAllIdByPid($data,3);
//      $data =  $model::getParentCateByCatId($data,7);
        $data =  $model->getAllIdByCatId($data,1);

        var_dump($data);
    }


}