<?php
/**
 * 跃飞科技版权所有 @2016
 */

/**
 * fanjd 1.2版 无限级分类扩展类
 * ============================================================================
 * * 版权所有 2005-2015 跃飞科技网络服务有限公司，并保留所有权利。
 * 网站地址: http://www.gtzhong.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: gtzhong $
 * $Email:gtzhong@gtzhong.com
 * $Id: Category.class.php  2015-1-13 20:58:03 gtzhong $
*/

namespace Component;
Class Category {
	/**
	 * 重新排序成新的一维数组，多用于后台无限级分类下拉选项
	 * @param  array  $cate  要处理的数组
	 * @param  string  $html  [description]
	 * @param  integer $pid   父级的ID
	 * @param  integer $level 等级
	 * @return array  新的一维数组
	 */
	Static Public function catesort($cate,$pid = 0, $level = 0){
		$arr = array();
		foreach($cate as $v){
			if ($v['parent_id'] == $pid){
				$v['level'] = $level +1;
				//$v['html'] = str_repeat($html, $level);
				$v['html'] = $level*27+3;
				$arr[] = $v;
				$arr = array_merge($arr, self::catesort($cate, $v['cat_id'], $level + 1));
				
			}
		}
		return $arr;
	}

	/**
	 * 重新向原来的数组里多加一项，做成多维的数组，多用于前端菜单
	 * @param  array  $cate  要处理的数组
	 * @param  string  $name 给子类起名
	 * @param  integer $pid  父级的ID
	 * @return [type]        [description]
	 */
	Static Public function catesortforlayer($cate, $name = 'child', $pid = 0){
		$arr = array();
		foreach($cate as $v){
			if($v['pid'] == $pid){			
				$v[$name] = self::catesortforlayer($cate, $name, $v['id']);
				$arr[] = $v;				
			}
		}
		return $arr;
	}

	/**
	 * [getParents description]
	 * @param  [type] $cate [description]
	 * @param  [type] $id   [description]
	 * @return [type]       [description]
	 */
	Static Public function getParents ($cate, $id){
		$arr = array();
		foreach($cate as $v){
			if($v['id'] == $id){				
				$arr = array_merge($arr, self::getParents($cate, $v['pid']));
				$arr[] = $v;
			}
		}
		return $arr;
	}

	/**
	 * [getChildsId description]
	 * @param  [type] $cate [description]
	 * @param  [type] $pid  [description]
	 * @return [type]       [description]
	 */
	Static Public function getChildsId($cate, $pid){
		$arr = array();
		foreach($cate as $v){
			if($v['pid'] == $pid){
				$arr[] = $v['id'];
				$arr = array_merge($arr, self::getChildsId($cate, $v['id']));
				}
		}
		return $arr;
	}

	/**
	 * [getChilds description]
	 * @param  [type] $cate [description]
	 * @param  [type] $pid  [description]
	 * @return [type]       [description]
	 */
	Static Public function getChilds($cate, $pid){
		$arr = array();
		foreach($cate as $v){
			if($v['pid'] == $pid){
				$arr[] = $v;
				$arr = array_merge($arr, self::getChildsId($cate, $v['id']));
				}
		}
		return $arr;
	}
}
?>



