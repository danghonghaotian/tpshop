<?php
/**
 * User: 钟贵廷
 * Date: 2017/1/1
 * Time: 15:14
 */
namespace Home\Controller;
use Think\Controller;
class AddressController extends MemberCommonController
{

    public function index()
    {
        $addressModel =  D('Address');
        $addressInfo = $addressModel->getUserAddressInfo();
        $this->assign('addressInfo',$addressInfo);
        $this->display();
    }

    /**
     * 设置默认收货地址
     */
    public function setDefault($id)
    {
        $addressModel =  D('Address');
        $res = $addressModel->setDefault($id);
        if($res === 1)
        {
            $this->success('设置成功');
        }
    }

    /**
     * 添加收货人地址
     */
    public function add()
    {
        if(IS_POST)
        {
            $model =  D('Address');
            // 接收并验证表单
            if($model->create())
            {
                // 插入数据库
                if($model->add() !== FALSE)
                {
                    $this->success('添加成功', U('index'));
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql().' - ERROR:'.mysql_error();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());  // 输出表单验证失败的原因
        }

        $addressModel =  D('Address');
        $province =  $addressModel->getProvince();
        $this->assign('province',$province);
        $this->display();
    }

    /**
     * 异步获取城市信息
     */
    public function ajaxGetCity()
    {
        $provinceId = $_POST['provinceId'];
        $id = $_POST['id'];
        if($provinceId != -1)
        {
            $region = M('Region');
            $city = $region->where(array('region_type'=>2,'parent_id'=>$provinceId))->select();
            if($id != -1)  //修改地址时
            {
                $addressModel = M('Address');
                $userCityId = $addressModel->getFieldById($id,'city');
                $city['userCityId'] = $userCityId;
            }
            echo json_encode($city);
        }
        else
        {
            echo '';
        }
    }

    /**
     * 异步获取县城信息
     */
    public function ajaxGetArea()
    {
        $cityId = $_POST['cityId'];
        if($cityId != -1)
        {
            $region = M('Region');
            $town = $region->where(array('region_type'=>3,'parent_id'=>$cityId))->select();
            echo json_encode($town);
        }
        else
        {
            echo '';
        }
    }

    public function delete($id)
    {
        $model =  D('Address');
        $res = $model->del($id);
        if($res)
        {
            $this->success('删除成功');
        }
    }

    
    public function save($id)
    {
        if(IS_POST)
        {
            $model = D('Address');
            if($model->create())
            {
                if($model->save() !== FALSE)
                {
                    $this->success('修改成功');
                    exit;
                }
                else
                {
                    if(APP_DEBUG)
                        echo 'SQL为：'.$model->getLastSql();
                    else
                        $this->error('发生失败，请重试！');
                }
            }
            else
                $this->error($model->getError());
        }

        $addressModel =  D('Address');
        $province =  $addressModel->getProvince();
        $addressInfo = $addressModel->find($id);
        $this->assign('province',$province);
        $this->assign('addressInfo',$addressInfo);
        $this->display();
    }



}