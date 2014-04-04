<?php

class AnnounceAction extends CommonAction{

        public function index() {

	        //获取分页设置
	        $Model=M('Model');
	        $map['table']=array('eq','Announce');
	        $pageinfo=$Model->where($map)->find();
	        $Form   =   M('Announce');
	        import("@.ORG.Page");       //导入分页类
	        $count  = $Form->where($map)->count();    //计算总数
	        $Page = new Page($count, $pageinfo['listrows'],'','','a','on');
	        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('create_time,id desc')->select();

	        // 设置分页显示
	        $Page->setConfig('header', $pageinfo['header']);
	        $Page->setConfig('first', $pageinfo['first']);
	        $Page->setConfig('last', $pageinfo['last']);
	        $Page->setConfig('prev', $pageinfo['prev']);
	        $Page->setConfig('next', $pageinfo['next']);
	        $Page->setConfig('theme',$pageinfo['theme']);
	        $page = $Page->show();
	        
	        $this->seo(C("SITE_NAME"), C("SITE_KEYWORDS"), C("SITE_DESCRIPTION"), '');
	        $this->assign("data", $catdata);
	        $this->assign("page", $page);
	        $this->assign("list", $list);
	        $this->display(); 
    }
}

?>
