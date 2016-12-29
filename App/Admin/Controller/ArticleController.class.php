<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/10
 * Time: 9:23
 */
namespace Admin\Controller;
use Think\Controller;

class ArticleController extends AdminController
{
    /**
     * 文章列表
     */
    public function lst($keyword = '')
    {
       $article_model =  D('article');
       $data = $article_model->search(trim($keyword));
       $article_data = $data["data"];
       $page = $data['page'];//分页
        //获取分类名
       $article_cat_model = D("ArticleCat");
       $cat_name =  $article_cat_model->getCatName();
       $this->assign("cat_name",$cat_name);
       $this->assign("article_data",$article_data);
       $this->assign("page",$page);
       $this->display();
    }

    /**
     * 添加文章
     */
    public function add()
    {
        if(IS_POST)
        {
            $model = D('Article');
            // 接收并验证表单
            if($model->create())
            {
                $model->replaceImgUrl(); //美化百度编辑器上传图片的地址
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
        //取出分类
        $article_cat = D('ArticleCat');
        $data =  $article_cat->field('cat_id,cat_name,parent_id')->select();
        $article_cat_data =  $article_cat->tree($data);
        $this->assign('article_cat_data', $article_cat_data);
        $this->display();
    }

    /**
     * 修改文章
     * @param $article_id
     */
    public function save($article_id)
    {
        if(IS_POST)
        {
            $model = D('Article');
            if($model->create())
            {

                $model->replaceImgUrl(); //美化百度编辑器上传图片的地址

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

        $article_model = D("Article");
        $article_data = $article_model->find($article_id);
        $this->assign("article_data", $article_data);
        //取出分类
        $article_cat = D('ArticleCat');
        $data =  $article_cat->field('cat_id,cat_name,parent_id')->select();
        $article_cat_data =  $article_cat->tree($data);
        $this->assign('article_cat_data', $article_cat_data);
        $this->display();
    }

    /**
     * 删除文章
     * @param $article_id
     */
    public function delete($article_id)
    {
        $article_model = D('Article');
        $article_data = $article_model->where(array('article_id'=>$article_id))->count();
        if($article_data>0)
        {
            $article_model->delete($article_id);
            $this->success("删除成功！");
        }
        else
        {
            $this->error("手贱，滚蛋吧！");
        }
    }
}