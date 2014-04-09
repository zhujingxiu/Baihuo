<?php

class ContentController extends CommonController{
    public function index() {
        C('SHOW_PAGE_TRACE',false);
        C('SHOW_RUN_TIME',false);
        $id = I('id');
        $catdata = D('Category')->where('status=1')->find($id);

        $this->assign("data", $catdata);
        $position=D('Common')->getPosition($id);
        $this->seo(($catdata['title'])?$catdata['title']:C(SITE_TITLE), ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        
        $leftset_html = '';
        if(!empty($catdata['pid'])){
            $leftset = $this->left_side($catdata['pid']);
            if($leftset){
                foreach ($leftset as $key => $item) {
                    $tmp = array();
                    $tmp = $item;
                    $tmp['catename'] = getCategoryName($item['cateid']);
                    $tmp['modelname'] = getModuleById($item['cateid']);
                    $tmp['data'] = D($tmp['modelname'])->field('id,title,thumb,create_time')->where("catid = '".$item['cateid']."'")->order('create_time desc')->limit($item['lmt'])->select();
                    $this->left = $tmp;
                    $leftset_html .= $this->fetch($item['tpl']);
                }
            }
        }else{
            $leftset_html .= $this->fetch('public:left_about');
        }
        $this->leftset_html = $leftset_html;
        if(!empty($catdata['detail_tpl'])){
        	$this->display($catdata['detail_tpl']); 
        }else{
        	$this->display(); 	
        }
        
    }
 
}

?>