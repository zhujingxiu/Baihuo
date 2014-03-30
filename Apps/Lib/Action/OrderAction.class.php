<?php

class OrderAction extends CommonAction{
    public function index() {
       if(!isset($_SESSION['account'])){
            $this->redirect('Member/login');
        }
        if(IS_POST){
            //修改购物车数量
            $id=$_REQUEST['id'];
            $num=$_REQUEST['num'];
            
            $scmodel = D('Shopcart');
            for($i=0;$i<count($id);$i++){
                $data = array();
                $data['id']=$id[$i];
                $data['num']=$num[$i];
                $up = $scmodel->save($data);
                $cartid .= $id[$i].",";
            }
            
            //获取订购信息
            $map['id']=array('in',explode(',', $cartid));
            $map['memberid']=array('eq',$_SESSION['id']);
            $map['status']=array('eq',1);
            $model=M('Shopcart');
            $list=$model->where($map)->select();
            if(is_array($list)){
                 foreach ($list as $key=>$val){
                     $map1['id']=array('eq',$val['proid']);
                     $map1['status']=array('eq',1);
                     $list[$key]['sub_list'] = D('Product')->where($map1)->find();
                 }
             }
             $this->list=$list;

        }  else {
            $id=$_REQUEST['id'];
            $map['id'] = array('in', explode(',', $id));
            $map['status']=array('eq',1);
            
            $model=M('Product');
            $list=$model->where($map)->select();
            $this->list=$list;
        }
        $position[]=array('id'=>'order','catname'=>'确认订单信息');
        $this->seo('确认订单信息', '', '', $position);
        $this->display();
       
    }
    public function show() {
        if(!isset($_SESSION['account'])){
            $this->redirect('Member/login');
        }
            $model = D('Order');
            if ($vo = $model->create()) {
                //创建订单号
                $model->orderid=$orderid=createOrderId();
                if(isset($_SESSION['id'])){
                    $model->memberid=$_SESSION['id'];
                }else{
                    $model->memberid=0;
                }
                $model->ip=get_client_ip();
                $model->status=2;
                $model->create_time=time();
                $list = $model->add();
                if ($list != false) {
                    $type=$_REQUEST['type'];
                    if($type){
                        $scmodel = D('Shopcart');//购物车
                        $cartid=$_REQUEST['cartid'];
                    }
                    
                    
                    $id=$_REQUEST['id'];
                    $price=$_REQUEST['price'];
                    $num=$_REQUEST['num'];
                    $allprice=$_REQUEST['allprice'];
                    $orderdetail=D('Orderdetail');//订单详细
                    
                    if($orderdetail->create()){
                        for($i=0; $i<count($allprice); $i++){
                            //加入订单详细
                            $orderdetail->orderid=$list;
                            $orderdetail->proid=$id[$i];
                            $orderdetail->price=$price[$i];
                            $orderdetail->num=$num[$i];
                            $orderdetail->allprice=$allprice[$i];
                            $orderdetail->status=2;
                            $orderdetail->create_time=time();
                            $ok=$orderdetail->add();
                            if($type){
                                 //删除购物车商品
                                $data = array();
                                $data['id']=$cartid[$i];
                                $data['status']=-1;

                                $up = $scmodel->save($data);
                            }
                           
                            
                        }
                    }
                    
                    if($ok){
                     
                        $this->success="操作成功<br>您的订单号是：$orderid<br>我们的销售代表将主动和您联系！";
                        $this->display();
                    }

                } else {
                    //失败提示
                    $this->error('订单提交失败，请稍后重试!');
                }
            }else{
                $this->error($model->getError());
            }
        
        
        
        
    }
}

?>
