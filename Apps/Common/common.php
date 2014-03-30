<?php
//创建订单
function createOrderId(){
    $time=date('YmdHis',time());
    $radnum=mt_rand(100,999);
    return $time.$radnum;
}
function IP($ip = '', $file = 'UTFWry.dat') {
	$_ip = array ();
	if (isset ( $_ip [$ip] )) {
		return $_ip [$ip];
	} else {
		import ( "ORG.Net.IpLocation" );
		$iplocation = new IpLocation ( $file );
		$location = $iplocation->getlocation ( $ip );
		$_ip [$ip] = $location ['country'] . $location ['area'];
	}
	return $_ip [$ip];
}
//将数组转化为树形数组   
 function arrToTree($data,$pid){  
        foreach($data as $k => $v){  
            if($v['pid'] == $pid){  
                $id.=arrToTree($data,$v['id']);  
                $id.=$v['id'].',';                

            }  
        }  
         return $id;
 } 
//根据ID获得分类名
function getCategoryName($id){
	if (empty ( $id )) {
		return '顶级分类';
	}
	$Category = D ( "Category" );
	$list = $Category->getField ( 'id,catname' );
	$name = $list [$id];
	return $name;
}
//根据ID获得模型名
function getModuleById($id){
	$Category = D ( "Category" );
	$list = $Category->getField ( 'id,modelname' );
	$module = $list [$id];
	return $module;
}
//公共函数
function toDate($time, $format = 'Y-m-d H:i:s') {
	if (empty ( $time )) {
		return '';
	}
	$format = str_replace ( '#', ':', $format );
	return date ($format, $time );
}
//MD5
function pwdHash($password, $type = 'md5') {
	return hash ( $type, $password );
}
//订单状态
function getOrderStatus($status, $imageShow = false) {
	switch ($status) {
                case - 1 :
			$showText = '删除';
			$showImg = '<img src="__PUBLIC__/Images/del.gif" width="20" height="20" border="0" alt="删除">';
			break;
		case 0 :
			$showText = '退货';
			$showImg = '<img src="__PUBLIC__/Images/locked.gif" width="20" height="20" border="0" alt="退货">';
			break;
		case 1 :
                        $showText = '<strong style="color:#487C09;">交易完成</strong>';
			$showImg = '<img src="__PUBLIC__/Images/ok.gif" width="20" height="20" border="0" alt="交易完成">';
                        break;
                case 2 :
			$showText = '<strong style="color:#0066CC;">未发货</strong>';
			$showImg = '<img src="__PUBLIC__/Images/prected.gif" width="20" height="20" border="0" alt="未发货">';
			break;
                case 3 :
			$showText = '<span style="color:#0066CC;">已发货</span>';
			$showImg = '<img src="__PUBLIC__/Images/prected.gif" width="20" height="20" border="0" alt="已发货">';
			break;
	
	}
	return ($imageShow === true) ?  $showImg  : $showText;

}


//获取会员名称
function getMemberName($id){
    if($id==0){
        $name = '游客';
    }else{
        $Member = D ( "Member" );
        $list = $Member->getField ( 'id,name' );
        $name = $list [$id];
    }
    return $name;
}
/**
 * 计算数组长度减一 一般用于栏目加载
 * @param type $var
 * @return type
 */
function toCount($var){
    return count($var)-0;
}
//字符串截取，支持中文和其他编码
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=false) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}
