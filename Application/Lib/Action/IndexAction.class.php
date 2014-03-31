<?php

class IndexAction extends CommonAction {

    public function index(){
        
        //友情链接
        $model=D('Link');
        $list=$model->order('listorder asc')->select();
        
        $position[]=array('id'=>0,'catname'=>'首页');
        $this->seo(C(SITE_TITLE), C(SITE_KEYWORDS), C(SITE_DESCRIPTION), $position);
        $this->list=$list;
        //Cookie::set('_currentUrl_', __SELF__);
        session('_currentUrl_', __SELF__);
        $this->display();
    }
 
}