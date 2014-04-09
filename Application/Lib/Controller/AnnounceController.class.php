<?php

class AnnounceController extends CommonController{

    public function index() {
			C('SHOW_PAGE_TRACE',false);
        	C('SHOW_RUN_TIME',false);
	        //获取分页设置
	        $Model=M('Model');
	        $map['table']=array('eq','Announce');
	        $pageinfo=$Model->where($map)->find();
	        $Form   =   M('Announce');
	        import("@.ORG.Page");       //导入分页类
	        $count  = $Form->where($map)->count();    //计算总数
	        $Page = new Page($count, $pageinfo['listrows'],'','','a','on');
	        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('starttime desc,id desc')->select();

	        // 设置分页显示
	        $Page->setConfig('header', $pageinfo['header']);
	        $Page->setConfig('first', $pageinfo['first']);
	        $Page->setConfig('last', $pageinfo['last']);
	        $Page->setConfig('prev', $pageinfo['prev']);
	        $Page->setConfig('next', $pageinfo['next']);
	        $Page->setConfig('theme',$pageinfo['theme']);
	        $page = $Page->show();
	        
	        $this->seo('最新公告 - '.C("SITE_NAME"), C("SITE_KEYWORDS"), C("SITE_DESCRIPTION"), '');
	        $this->leftset_html = $this->fetch('public:left_about');
	        $this->assign("page", $page);
	        $this->assign("list", $list);
	        $this->display(); 
    }


}

?>
