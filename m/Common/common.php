<?php
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
