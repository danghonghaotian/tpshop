<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/13
 * Time: 19:55
 */


namespace Admin\Model;
use Think\Model;
class AdPositionModel extends Model
{

    protected $_validate = array(
        array('adpos_name',"require","广告位名称必须!"),
        array('adpos_width',"number","宽度必须为大于0的数字!"),
        array('adpos_height',"number","高度必须为大于0的数字!"),

    );
    
    
    /**
     * 搜索
     * @return array
     */
    public function search($keyword)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        $where .= " and (adpos_name like '%$keyword%')";
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个广告位';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit( $page->limit)->order("id desc")->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }


    public function getAdPositionInfoByAdId($id)
    {
        $ad = $this->find($id);
        return $ad;
    }

}