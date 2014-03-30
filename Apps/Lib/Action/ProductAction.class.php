<?php

class ProductAction extends CommonAction{
    //过滤查询字段
    function _filter(&$map){
        
        if(isset($_GET['keyword'])){
            $keyword=  I('keyword');
            if(!empty($keyword)){
                $map['title']=array('like','%'.$keyword.'%');
            }
        }
        if(isset($_POST['search'])){
            $keyword=  I('search');
            if(!empty($keyword)){
                $map['title']=array('like','%'.$keyword.'%');
            } 
        }
        
        
    }
    
}

?>
