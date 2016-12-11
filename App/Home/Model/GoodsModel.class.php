<?php
/**
 * User: 钟贵廷
 * Date: 2016/12/10
 * Time: 20:42
 */

namespace Home\Model;
use Think\Model;

class GoodsModel extends Model
{

    /**
     * 获取商品的单选属性数据
     * @param $id
     * @return array
     */
    public function getGoodsAttrRadioData($id)
    {
        $prefix = C('DB_PREFIX');
        $sql = 'SELECT a.id,a.goods_id,a.attr_id,a.attr_value,a.attr_price,b.attr_name,b.attr_type,b.goods_type_id from '.$prefix.'goods_attr as a LEFT JOIN '.$prefix.'attribute as b on  a.attr_id = b.id WHERE goods_id ='.$id.' and attr_type = 1';
        $attr =  M()->query($sql);
        $data = array();
        foreach ($attr as $k=>$v)
        {
            $data[$v['attr_name']][] = array($v['attr_id'],$v['attr_value']);
        }
        return $data;
    }

    /**
     * 根据子类id找出所有包含子类与父类的数组(面包屑)
     * @param $cate
     * @param $id
     * @return array
     */
    public function getAllParentCatByCatId($cate, $id)
    {
        $arr = array();
        foreach($cate as $v)
        {
            if($v['id'] == $id)
            {
                $v['url'] = U('Home/Goods/lst',array('cid'=>$v['id']));
                $arr = array_merge($arr, self::getAllParentCatByCatId($cate, $v['parent_id']));
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /**
     *根据pid获取所有的子id
     * 包含父id
     * @param $arr
     * @param $parent_id
     * @return array
     */
    public function getAllIdByPid($arr,$parent_id)
    {
        static $cateId = array();
        $cateId[] = (string)$parent_id;
        foreach($arr as $v)
        {
            if($v['parent_id'] == $parent_id)
            {
                $cateId[] = $v['id'];
                $cateId = $this->getAllIdByPid($arr, $v['id']);
            }
        }
        return array_unique($cateId);
    }


    /**
     * @param $ids
     * @return array
     */
    public function search($ids)
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = array('cat_id'=> array('in',$ids),'is_on_sale'=>1,'is_delete'=>0);
//        dump($where);die;
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
//        echo $count;
//        die;
        // 2. 生成翻页类的对象
        $page = new \Home\Component\Page($count,C('goods_page'));
        $page->config['header'] = '个商品';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage(array(3,4,5,6,7,0,8));
//        echo $page->limit;die;
        // 4. 取出当前页的数据
        $data = $this->field(array('id','goods_name','market_price','shop_price','sm1_logo'))->where($where)->limit( $page->limit)->order('id desc')->select();
//        echo $this->getLastSql();die;
        return array(
            'page' => $pageStr,
            'data' => $data,
        );
    }


    /**
     * 构造含有child下标的数组
     * @param $cate
     * @param string $name
     * @param int $pid
     * @return array
     */
    public function getChildArr($cate, $name = 'child', $pid = 0)
    {
        $arr = array();
        foreach($cate as $v)
        {
            if($v['parent_id'] == $pid)
            {
                $v[$name] = self::getChildArr($cate, $name, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }
    
    
    



}