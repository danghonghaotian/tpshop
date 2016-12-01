<?php
/**
 * 跃飞科技版权所有 @2016
 * User: zhong
 * Date: 2016/8/18
 * Time: 15:54
 */
namespace Admin\Model;
use Think\Model;

class GoodsTypeModel extends Model
{
    protected $_validate = array(
        array('type_name',"require","商品类型名称不能为空!"),
    );

    public function search()
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Think\Page($count,10);
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->show();
        // 4. 取出当前页的数据
        $data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }

    /**
     *  获取类型
     * @return array
     */
    public function getType()
    {
        $data = array();
        $goodsTypeData = $this->select();
        foreach ($goodsTypeData as $v)
        {
            $data[$v['id']] = $v['type_name'];
        }
        return $data;
    }
}