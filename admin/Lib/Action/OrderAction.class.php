<?php
class OrderAction extends CommonAction {
    //过滤查询字段
    function _filter(&$map){
        if(isset($_POST['zt'])&&$_POST['zt']!=-2){
            $map['status'] = array('eq',$_POST['zt']);
            $this->zt=$_POST['zt'];
        }
        $map['orderid'] = array('like',"%".$_POST['ddid']."%");
    }
    function edit() {
        $name = $this->getActionName();
        $model = M($name);
        $id = $_REQUEST [$model->getPk()];
        $vo = $model->getById($id);
        
        //根据ID获取产品信息
        $map['orderid']=array('eq',$vo['id']);
	$Product=D("Orderdetail");
	$list=$Product->where($map)->select();
        if(is_array($list)){
            foreach ($list as $key=>$val){
                $map1['id']=array('eq',$val['proid']);
                $map1['status']=array('eq',1);
                $list[$key]['sub_list'] = D('Product')->where($map1)->find();
            }
        }
        
	$this->assign('list', $list);

        $this->assign('vo', $vo);
        $this->display();
    }
}
?>