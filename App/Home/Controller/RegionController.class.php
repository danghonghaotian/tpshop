<?php
namespace Home\Controller;
use Think\Controller;
class RegionController extends Controller
{
	/**
	 *没有的控制器，直接跳到首页
	 */
	public function _empty()
	{
		$this->error('404,该页面不存在',U('Home/Index/index'),1);
	}

	public function index()
	{
		$country = $this->getCountry();
		$this->assign('country',$country);
		$this->display();
	}

    //获取国家
	public function getCountry()
	{
		$region = M('Region');
		$country = $region->where(array('region_type'=>0))->find();	
		return $country;
	}

	//获取省份数据
	public function getProvince()
	{
		$countryId = $_POST['countryId'];
		if($countryId != -1)
		{
			$region = M('Region');
			$provice = $region->where(array('region_type'=>1,'parent_id'=>$countryId))->select();
			echo json_encode($provice);	
		}
		else
		{
			echo '';
		}

	}

	public function getCity()
	{
		$provinceId = $_POST['provinceId'];
		if($provinceId != -1)
		{
			$region = M('Region');
			$city = $region->where(array('region_type'=>2,'parent_id'=>$provinceId))->select();
			echo json_encode($city);	
		}
		else
		{
			echo '';
		}
	}

	public function getTown()
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


}