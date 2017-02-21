<?php
/**
 * User: 钟贵廷
 * Date: 2017/2/21
 * Time: 19:31
 */

namespace Admin\Model;
use Think\Model;
class ActivityModel extends Model
{
    protected $_validate = array(
        array('title',"require","标题不能为空"),
        array('goods_sn',"require","商品sn不能为空"),
        array('link',"require","活动链接不能为空"),
    );

    protected $_auto = array(
        array('add_time','time',self::MODEL_INSERT,'function'),
    );

    /**
     * 搜索
     * @return array
     */
    public function search($keyword)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        $where .= " and (title like '%$keyword%' or link like '%$keyword%')";
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个活动';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->order("id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }

}