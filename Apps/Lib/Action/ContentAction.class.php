<?php

class ContentAction extends CommonAction{
    public function index() {
        
        $id = I('id');
        $catdata = D('Category')->where('status=1')->find($id);
        $this->assign("data", $catdata);
        $position=D('Common')->getPosition($id);
        $this->seo(($catdata['title'])?$catdata['title']:C(SITE_TITLE), ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);

        $this->display(); 
    }
 
}

?>
