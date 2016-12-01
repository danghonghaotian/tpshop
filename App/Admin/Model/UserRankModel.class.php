<?php
/**
 * 跃飞科技版权所有 @2016
 * User: 钟贵廷
 * Date: 2016/11/30
 * Time: 13:33
 */

namespace Admin\Model;
use Think\Model;
class UserRankModel extends Model
{
    protected $_validate = array(
        array('level_name',"require","会员等级名称不能为空"),
        array('low_num',"require","积分下限不能为空"),
        array('top_num',"require","积分上限不能为空"),
        array('rate',"require","折扣率不能为空"),
    );

    /**
     * 搜索
     * @return array
     */
    public function search()
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '条记录';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }

}