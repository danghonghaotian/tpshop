<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/10
 * Time: 9:23
 */
namespace Api\Controller;
use Think\Controller;

class ArticleController extends Controller
{
    private  $_token;
    public function __construct()
    {
        $this->_token = '123456';
        if($this->_token != $_GET['token'])
        {
            echo "无权访问";
            die;
        }
        parent::__construct();
    }

    /**
     * 添加文章接口
     */
    public function add()
    {
        if (IS_POST)
        {
            $model = D('Article');
            // 接收并验证表单
            if ($model->create())
            {
                // 插入数据库
                if ($model->add() !== FALSE)
                {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else
                {
                    if (APP_DEBUG)
                        echo 'SQL为：' . $model->getLastSql() . ' - ERROR:' . mysql_error();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());  // 输出表单验证失败的原因
        }
        else
        {
            $this->error('非法操作！');
        }
    }

    /**
     * 修改文章
     * @param $article_id
     */
    public function save($article_id)
    {
        if (IS_POST) {
            $model = D('Article');
            if ($model->create()) {
                if ($model->save() !== FALSE) {
                    $this->success('修改成功', U('lst'));
                    exit;
                } else {
                    if (APP_DEBUG)
                        echo 'SQL为：' . $model->getLastSql();
                    else
                        $this->error('发生失败，请重试！');
                }
            } else
                $this->error($model->getError());
        }

    }

    /**
     * 删除文章
     * @param $article_id
     */
    public function delete($article_id)
    {
        $article_model = D('Article');
        $article_data = $article_model->where(array('article_id' => $article_id))->count();
        if ($article_data > 0) {
            $article_model->delete($article_id);
            $this->success("删除成功！");
        } else {
            $this->error("手贱，滚蛋吧！");
        }
    }

    public function test()
    {
        echo "test";
    }
}