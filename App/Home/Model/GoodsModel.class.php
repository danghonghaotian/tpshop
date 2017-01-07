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
     * 获取商品的唯一属性
     * @param $goods_id
     * @return array
     */
    public function getUnitAttrByGoodsId($goods_id)
    {
        $prefix = C('DB_PREFIX');
        $sql = 'SELECT a.attr_value,b.attr_name from '.$prefix.'goods_attr as a LEFT JOIN '.$prefix.'attribute as b on  a.attr_id = b.id WHERE a.goods_id = '.$goods_id.' and b.attr_type=0';
        $attr =  M()->query($sql);
        $data = array();
        foreach ($attr as $k=>$v)
        {
            $data[$v['attr_name']] = $v['attr_value'];
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
    public function search($ids,$keyword='')
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        if($ids)
        {
             $where = array('cat_id'=> array('in',$ids),'is_on_sale'=>1,'is_delete'=>0);
        }
        if($keyword)
        {
            $where = array('goods_name'=> array('like',"%$keyword%"),'is_on_sale'=>1,'is_delete'=>0);
        }
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


    /**
     * 获取最新的5条商品数据
     * @return mixed
     */
    public function getNewGoods()
    {
        $goodsModel = M('Goods');
        $goods = $goodsModel->where(array('is_delete'=>0))->order('id desc')->limit(5)->select();
        return $goods;
    }

    /**
     * 获取商品历史记录
     * @param $goods_id
     */
    public function getGoodsHistory($goods_id)
    {
        $goods_id = (int)$goods_id;
        // 先从COOKIE中取出这前浏览过的商品
        $goods = cookie('goodsHistory'); // 1,2,3,4,5
        $goods = explode(',', $goods);
        // 把当前浏览的商品放到数组中的第一个位置上
        array_unshift($goods, $goods_id);
        // 去重
        $goods = array_unique($goods);
        if(count($goods) > 5)
        {
            $goods = array_splice($goods, 0, 5); //只保存前5件商品记录
        }
        $goods = implode(',', $goods);
        $goods = trim($goods, ',');
        $domain = strstr($_SERVER['HTTP_HOST'],'.');
        // 存回到COOKIE
        cookie('goodsHistory', $goods, 'expire='.(30*86400).'&path=/');
        // cookie中的path和domain有什么用？
        //.tpshop.com 代表所有域名都可以访问到
        // path /表示当前目录及子目录下可以访问
        /********* 根据商品ID取出商品信息 *************/
        $goodsArr = explode(',',$goods);

        $data =array();
        foreach ($goodsArr as $k=>$v)
        {
            $data[] = $this->field('id,sm_logo,goods_name')->find($v);
        }

        return  $data;
    }


    public function getGoodsListHistory()
    {
        $goods = cookie('goodsHistory'); // 1,2,3,4,5
        $goodsArr = explode(',',$goods);

        $data =array();
        foreach ($goodsArr as $k=>$v)
        {
            $data[] = $this->field('id,sm_logo,goods_name')->find($v);
        }

        return  $data;
    }
    
    
    



}