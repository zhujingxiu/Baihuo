<?php
class NodeController extends CommonController {
    public function _filter(&$map)
    {
        $map['status'] = array('egt',0);
        $map['title'] = array('like',"%".$_POST['name']."%");
    }
    public function _before_index() {
        $node=new NodeModel();
        $menu=$node->getMenu();
        $tree=outNode($menu);
        $this->assign('tree', $tree); 
    }
    public function insert() {
        $map['id'] = $_POST['pid'];
        $name = $this->getControllerName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        
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
    // 获取配置类型
    public function _before_add() {
        $node=new NodeModel();
        $menu=$node->getMenu();
        if(isset($_REQUEST ['id'])){
            $selecttree=outNodeSelect($menu,$_REQUEST ['id']);
        }else{
            $selecttree=outNodeSelect($menu,0);
        }
        
        $this->assign('selecttree', $selecttree); 
    }

    function update() {
        $map['id'] = $_POST['pid'];
        $name = $this->getControllerName();
        $model = D($name);
        if (false === $model->create()) {
            $this->error($model->getError());
        }
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
    public function _before_edit() {
        $map['id']=$_REQUEST ['id'];
        $node=new NodeModel();
        $menu=$node->getMenu();
        $pid=$node->where($map)->getField('pid');
        $selecttree=outNodeSelect($menu,$pid);
        $this->assign('selecttree', $selecttree); 
    }

}
?>