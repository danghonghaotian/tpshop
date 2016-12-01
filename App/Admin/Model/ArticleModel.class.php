<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/10
 * Time: 16:37
 */
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model
{
    protected $_validate = array(
        array('title',"require","文章标题必须!"),
        array('cat_id',"require","文章分类必须!"),
        array('content',"require","文章内容必须!"),
    );

    protected $_auto = array(
        array('add_time','time',self::MODEL_INSERT,'function')
    );

    public function search()
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Think\Page($count,C('PAGE_SIZE'));
        $page->setConfig('prev',  '上一页');
        $page->setConfig('next',  '下一页');
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->show();
        // 4. 取出当前页的数据
        $data = $this->field('article_id,cat_id,title,article_type,is_open,add_time')->where($where)->limit($page->firstRow.','.$page->listRows)->order("article_id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }
}