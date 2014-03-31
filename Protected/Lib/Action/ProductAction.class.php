<?php

class ProductAction extends CommonAction{
    function _initialize() {
        import('@.ORG.Util.Cookie');
        //检查认证识别号
        if (!$_SESSION [C('USER_AUTH_KEY')]) {
            //跳转到认证网关
            redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
        }
    }
    //过滤查询字段
    function _filter(&$map){
        if(isset($_GET['catid'])){
            $map['catid']=  array('eq',$_GET['catid']);
        }
        if(isset($_POST['catid'])){
            $map['catid']=  array('eq',$_POST['catid']);
        }
        
        $map['title'] = array('like',"%".$_POST['name']."%");
    }
    public function _before_index() {
        if(isset($_GET['catid'])){
            $this->catid=$_GET['catid'];
        }
        if(isset($_POST['catid'])){
            $this->catid=$_POST['catid'];
        }
    }
    public function _before_add() {
        if(isset($_GET['id'])){
            $this->catid=$_GET['id'];
        }
        
    }
    public function _before_insert() {
        $_POST['content']=  str_replace(__ROOT__.'/'.APP_NAME.'/Tpl/Public/ueditor/php/../../../../../Uploads', __ROOT__.'/Uploads', $_POST['content']);
    }
    public function _before_update() {
        
        $_POST['content']= str_replace(__ROOT__.'/'.APP_NAME.'/Tpl/Public/ueditor/php/../../../../../Uploads', __ROOT__.'/Uploads', $_POST['content']);
    }
}

?>
