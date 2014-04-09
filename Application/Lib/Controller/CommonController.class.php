<?php
/*前台动作基类*/
class CommonController extends Controller {
    //初始化
    function _initialize(){
        header("Content-Type:text/html; charset=utf-8");
        //import('@.ORG.Util.Cookie');
        
        //栏目导航
        $nav_list = D('Category')->where('pid=0 AND status=1')->order('listorder')->select();
        if(is_array($nav_list)){
            
            foreach ($nav_list as $key=>$val){
                $nav_list[$key] = $this->changurl($val);
                $nav_list[$key]['sub_nav'] = D('Category')->where('pid='.$val['id'].' AND status=1')->select();
                
                foreach ($nav_list[$key]['sub_nav'] as $key2=>$val2){
                    $nav_list[$key]['sub_nav'][$key2] = $this->changurl($val2);
                }
            }
        }
        
        $this->nav_list = $nav_list;
        
        //每日流量统计
        $tjdate=D('Tjdate');
        $map['create_date']=array('eq',date('Ymd',time()));
        $vl=$tjdate->where($map)->find();
        if($vl){
            $tjdate->id=$vl['id'];
            $tjdate->create_num=$vl['create_num']+1;
            $tjdate->save();
        }else{
            $tjdate->create_date=date('Ymd',time());
            $tjdate->create_num=1;
            $tjdate->add();
        }
        
        //页面流量统计
        $tjurl=D('Tjurl');
        $map['create_url']=__SELF__;
        $vla=$tjurl->where($map)->find();
        if($vla){
            $tjurl->id=$vla['id'];
            $tjurl->create_num=$vla['create_num']+1;
            $tjurl->save();
        }else{
            $tjurl->create_url=__SELF__;
            $tjurl->create_num=1;
            $tjurl->add();
        }
     
        $this->sitename=C(SITE_NAME);//站点名称
        $this->wxqrcode=C('WX_QRCODE');
        
    }
   
    //SEO赋值
    public function seo($title,$keywords,$description,$positioin=''){
    	$this->title = $title;
    	$this->keywords = $keywords;
    	$this->description = $description;
    	$this->position = $positioin;
       
    }
    //URL转换
    public function changurl($ary){
    	if(is_array($ary)){
            if(key_exists('modelname', $ary)){
                if(!empty($ary['custom_url'])){
                    $ary['url'] = trim($ary['custom_url']);
                }else{
                    $ary['url']=U($ary['modelname'].'/index/',array('id'=>$ary['id'])).(!empty($ary['params']) ? trim($ary['params']) : '');    
                }
                
            }
            return $ary;
        }		
    }
    
    public function index() {
        
        if(method_exists($this, '_filter')){
            $this->_filter($map);
        }
        
        $id = I('id');
        $catdata = D('Category')->where('status=1')->find($id);	
        
        //获取所有子类id
        $catlist = D('Category')->where('status=1')->select();	
        $idlist = $id.','.arrToTree($catlist,$id);  
        $idlist= substr($idlist, 0, strlen($idlist)-1);
        $map['catid'] = array('in',$idlist);
        
        $name = $this->getControllerName();
        
        //获取分页设置
        $Model=M('Model');
        $map['table']=array('eq',$name);
        $pageinfo=$Model->where($map)->find();
        $Form   =   M($name);
        import("@.ORG.Page");       //导入分页类
        $count  = $Form->where($map)->count();    //计算总数
        $Page = new Page($count, $pageinfo['listrows'],'','','a','on');
        $list   = $Form->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('listorder,id desc')->select();

        // 设置分页显示
        $Page->setConfig('header', $pageinfo['header']);
        $Page->setConfig('first', $pageinfo['first']);
        $Page->setConfig('last', $pageinfo['last']);
        $Page->setConfig('prev', $pageinfo['prev']);
        $Page->setConfig('next', $pageinfo['next']);
        $Page->setConfig('theme',$pageinfo['theme']);
        $page = $Page->show();

        $position=D('Common')->getPosition($id);
        foreach ($position as $value) {
            $title=$value['catname']."_".$title;
        }
        $title=  substr($title, 0, strlen($title)-1);
        
        $this->seo(($catdata['title'])?$catdata['title']:$title, ($catdata['keywords'])?$catdata['keywords']:C(SITE_KEYWORDS), ($catdata['description'])?$catdata['description']:C(SITE_DESCRIPTION), $position);
        $this->data = $catdata;
        $this->page = $page;
        $this->list = $list;
        $leftset = $this->left_side($id);

        $leftset_html = '';
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
        $this->leftset_html = $leftset_html;

        if(!empty($catdata['list_tpl'])){
            $this->display($catdata['list_tpl']); 
        }else{
            $this->display();   
        }
    }
    public function show()
    {
        $id= I('id');
        $name = $this->getControllerName();
        
        D($name)->where('id='.$id)->setInc('hits',1);//浏览次数
       
        $model=M($name);

        //当前记录
        $data=$model->find($id);
        if(!empty($data['catid'])){
            $data['category'] = $this->changurl(M('category')->find($data['catid']));
        }
        
        //上一条记录
        $prevdata=$model->where(" id < '".$id."' AND catid = '".$data['catid']."' ")->order('id desc')->limit('1')->find();
        
        //下一条记录
        $nextdata=$model->where(" id > '".$id."' AND catid = '".$data['catid']."' ")->order('id asc')->limit('1')->find();
        
        //seo设置
        $position=D('Common')->getPosition($data['catid']);
        $this->seo($data['title'], $data['keywords'], $data['description'], $position);
        
        //内链优化
        $Chain=D('Chain');
        $ChainMap['status']=array('eq',1);
        $Chainlist=$Chain->where($ChainMap)->select();
        foreach ($Chainlist as $key => $value) {
            $data['content']=preg_replace('/'.$value['keyword'].'/i',"<a href=".$value['url']." target=".$value['target'].">".$value['keyword']."</a>", $data['content'],$value['number']);
        }
        $leftset_html = '';
        $this->data = $data;
        $this->prevdata = $prevdata;
        $this->nextdata = $nextdata;

        if($data['catid']){
            $leftset = $this->left_side($data['catid']);
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
        //Cookie::set('_currentUrl_', __SELF__);
        session('_currentUrl_', __SELF__);
        if(!empty($data['category']['detail_tpl'])){
            $this->display($data['category']['detail_tpl']); 
        }else{
            $this->display();   
        }
    }
    
    protected function left_side($cateid,$last_level=false){
        if(!$cateid){
            return array();
        }
        if($last_level){
            $parent_cate = M('category')->field("pid")->find($cateid);
            $cate = M('category')->field("leftset")->find($parent_cate['pid']);
        }else{
            $cate = M('category')->field("leftset")->find($cateid);    
        }
        return !empty($cate['leftset']) ? $this->doLeftsetSort(json_decode($cate['leftset'],true)) : array();
    }

    protected function doLeftsetSort($leftset){
        $data = array();
        if($leftset){
            foreach ($leftset as $key => $item) {
                if(!$item['id']){ continue;}
                $item['cateid'] = $item['id'];
                $sort = empty($item['cateid']) ? 0 : (int)$item['sort'] ;
                $item['tpl'] = empty($item['tpl']) ? 'left' : trim($item['tpl']);
                $item['lmt'] = empty($item['lmt']) ? 10 : (int)$item['lmt'];
                $data[$sort.'-'.$item['cateid'].'-'.$key] = $item;
            }
            ksort($data);
        }
        return $data;
    }
    
}