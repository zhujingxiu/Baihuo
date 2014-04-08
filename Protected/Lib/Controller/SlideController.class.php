<?php
class SlideController extends CommonController {
    //过滤查询字段
    function _filter(&$map){
        $map['title'] = array('like',"%".$_POST['name']."%");
    }
    
}
?>