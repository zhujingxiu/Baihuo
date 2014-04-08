<?php

class CategoryController extends CommonController{
    //过滤查询字段
    function _filter(&$map){
        $map['catname'] = array('like',"%".$_POST['name']."%");
    }
    public function index() {
        //列表过滤器，生成查询Map对象
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        
        $cate=new CategoryModel();

        $menu =$cate->getMyCategory1(); //加载分类

        $menu = arrToMenu($menu,0);  
        $this->list=$menu;
        Cookie::set('_currentUrl_', __SELF__);
        $this->display();  
    }
    public function _before_add() {
        if(isset($_GET['id'])){
            $current_pid=$_GET['id'];
        }
        if(isset($_GET['model'])){
            $current_modelname=$_GET['model'];
        }
        $cate=new CategoryModel();
//        $this->list=$cate->getMyCategory();//加载分类
        $menu =$cate->getMyCategory1(); //加载分类
        $menu = arrToMenu($menu,0);  
        $this->list=$menu;
        $this->mdldata=$cate->getMyModel();//加载模型
        
        $this->current_pid=$current_pid;
        $this->current_modelname=$current_modelname;
    }
    public function _before_edit() {
        $cate=new CategoryModel();
//        $this->list=$cate->getMyCategory();//加载分类
        $menu =$cate->getMyCategory1(); //加载分类
        $menu = arrToMenu($menu,0);  
        $this->list=$menu;
        $this->mdldata=$cate->getMyModel();//加载模型
        
    }
    public function add() {
        $cates =M('category')->where("level = 1 AND modelname = 'Article' AND status = 1")->order('listorder ,id ')->select(); //加载分类
        $this->assign('cates', $cates);

        $this->display();
    }
    function edit() {
        $cates =M('category')->where("level = 1 AND modelname = 'Article' AND status = 1")->order('listorder ,id ')->select(); //加载分类
        $this->assign('cates', $cates);
        $name = $this->getControllerName();
        $model = M($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getById($id);
        $vo['leftset_last'] = 0;
        $leftset_html = '';
        if(!empty($vo['leftset'])){
            $leftset = json_decode($vo['leftset'],true);
            foreach ($leftset as $key => $item) {
                $catdata = D('Category')->where('level=1')->find($item['id']); 
                if(!empty($catdata['catname'])){
                    $leftset_html .= '<div class="selected-item">';
                    $leftset_html .= '<span><b><i>'.$catdata['catname'].'</i></b></span> ';
                    $leftset_html .= '<span>模板：<input class="ipt2" type="text" name="leftset[tpl][]" value="'.$item['tpl'].'"/></span> ';
                    $leftset_html .= '<span>条数：<input class="ipt1" type="text" name="leftset[lmt][]" value="'.$item['lmt'].'"/></span> ';
                    $leftset_html .= '<span>排序：<input class="ipt1" type="text" name="leftset[sort][]" value="'.$item['sort'].'"/></span> ';
                    $leftset_html .= '<input type="hidden" name="leftset[id][]" value="'.$item['id'].'">';
                    $leftset_html .= '<a class="close-selected-item">关闭</a>';
                    $leftset_html .= '</div>';
                    $vo['leftset_last'] = $item['id'];
                }
            }

        }
        $vo['leftset_html'] = $leftset_html;
        
        $this->assign('vo', $vo);
        $this->display();
    }
    function insert() {
        $this->_upload();
        
        $name = $this->getControllerName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $map['id'] = $_POST['pid'];
        $level=$model->where($map)->getField('level');
        $model->level = $level+1;
        //保存当前数据对象
        $list = $model->add();
        if ($list !== false) { //保存成功
            $this->assign('jumpUrl', Cookie::get('_currentUrl_'));
            $this->success('新增成功!');
        } else {
            //失败提示
            $this->error('新增失败!');
        }
    }
    function update() {
        $this->_upload();
        
        $name = $this->getControllerName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        $map['id'] = $_POST['pid'];
        $level=$model->where($map)->getField('level');
        $model->level = $level+1;
        // 更新数据
        $list = $model->save();
        if (false !== $list) {
            //成功提示
            $this->assign('jumpUrl', Cookie::get('_currentUrl_'));
            $this->success('编辑成功!');
        } else {
            //错误提示
            $this->error('编辑失败!');
        }
    }
   
  
}

?>
