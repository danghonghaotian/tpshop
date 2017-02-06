<?php
/**
 * 跃飞科技版权所有 @2017
 * User: 钟贵廷
 * Date: 2017/2/6
 * Time: 9:20
 */

namespace Admin\Model;
use Think\Model;
class OrderModel extends Model
{
    /**
     * 获取订单基本信息
     * @return mixed
     */
    public function search()
    {
        // 搜索所有的数据,如果需要搜索其他字段需要自己添加
        $where = 1;
//        $where .= " and (ad_name like '%$keyword%')";
        /** 翻页 **********/
        //1 . 算出总的记录数
        $count = $this->where($where)->count();
        // 2. 生成翻页类的对象
        $page = new \Admin\Component\Page($count,C('PAGE_SIZE'));
        $page->config['header'] = '个订单';
        // 3. 生成翻页的字符串：上一页、下一页
        $pageStr = $page->fpage();
        // 4. 取出当前页的数据
        $prefix = C('DB_PREFIX');
        $sql = "SELECT * from {$prefix}order as a LEFT JOIN {$prefix}user as b on a.user_id = b.user_id LIMIT {$page->limit}";
        $orderBasicInfo = $this->query($sql);

        //获取订单下的商品
        $arr = array();
        foreach ($orderBasicInfo as $k=>$v)
        {
            $orderGoods = self::getOrderGoods($v['id']);
            $arr[$k] = $orderBasicInfo[$k];
            $arr[$k]['orderGoods'] = $orderGoods;
        }
        return array(
            'page' => $pageStr,
            'data' => $arr,
        );
    }


    /**
     * 获取订单下的商品
     * @param $id
     * @return array
     */
    private static function getOrderGoods($id)
    {
        $orderGoodsModel = M('OrderGoods');
        $orderGoods = $orderGoodsModel->where(array('order_id'=>$id))->select();
        return $orderGoods;
    }


    /**
     * 获取订单详情
     * @param $id
     * @return mixed
     */
    public function getOrderDetailById($id)
    {
        $orderInfo = $this->find($id);
        $email = self::getUserName($orderInfo['user_id']);
        $orderGoods = self::getOrderGoods($orderInfo['id']);
        $orderInfo['email'] = $email;
        $orderInfo['orderGoods'] =  $orderGoods;
        return $orderInfo;
    }

    /**
     * 获取用户邮箱
     * @param $userId
     * @return mixed
     */
    private static function getUserName($userId)
    {
        $userModel = D('User');
        $email =  $userModel->getFieldByUserId($userId,'email');
        return $email;
    }

}