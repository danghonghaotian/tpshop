<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/11
 * Time: 17:16
 */
namespace Admin\Model;
use Think\Model;
class NavModel extends Model
{
    protected $_validate = array(
        array('name',"require","导航栏名称必须!"),
        array('url',"require","链接地址必须!"),
        array('view_order',"require","排序必须!")
    );

    public function search()
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个导航';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->order("position desc,is_show desc,view_order asc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }

    public function  getPosition()
    {
        return array('top'=>'顶部','middle'=>'中间','bottom'=>'底部');
    }
}