<?php

class ShopcartAction extends CommonAction{
    public function index() {
        
        if(!isset($_SESSION['account'])){
            $this->redirect('Member/login');
        }
        $map['memberid']=array('eq',$_SESSION['id']);
        $map['status']=array('eq',1);
        $model=M('Shopcart');
        $list=$model->where($map)->select();
        if(is_array($list)){
            foreach ($list as $key=>$val){
                $list[$key]['sub_list'] = D('Product')->where('id='.$val['proid'].' AND status=1')->find();
            }
        }
        $this->list=$list;
        $position[]=array('id'=>'shopcart','catname'=>'我的购物车');
        $this->seo('我的购物车', '', '', $position);
        $this->display();
    }
    public function add(){
        $id=I('id');
        if(!isset($_SESSION['account'])){
            $this->redirect('Member/login');
        }
        $map['memberid']=array('eq',$_SESSION['id']);
        $map['proid']=array('eq',$id);
        $map['status']=array('eq',1);
        $model = D('Shopcart');
        //判断产品是否已经在购物车中存在
        $vo=$model->where($map)->find();
        if($vo){
            //购物车中已存在此商品
            $data = array();
            $data['id']=$vo['id'];
            $data['num']=array('exp','num+1');
            $list = $model->save($data);
        }  else {
            //加入购物车
            $model->memberid=$_SESSION['id'];
            $model->proid=$id;
            $model->status=1;
            $model->num=1;
            $model->create_time=time();
            $list = $model->add(); 
        }
        if ($list != false) {
            $this->redirect('Shopcart/index');

        } else {
            //失败提示
            $this->error('加入购物车失败，请稍后重试!');
        }

    }

    
    
    
    
    
}

?>
