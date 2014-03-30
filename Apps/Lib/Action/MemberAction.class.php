<?php
// 后台用户模块
class MemberAction extends CommonAction {
    public function index() {
        if(isset($_SESSION['account'])) {
            $map['id']=array('eq',$_SESSION['id']);
            $Member=M('Member');
            $data=$Member->where($map)->find();
            $this->data=$data;
            $position[]=array('id'=>'index','catname'=>'会员中心');
            $this->seo('会员中心', '', '', $position);
            $this->display();
        }else{
            $this->redirect('Member/login');
        }
    }

    // 用户登录页面
    public function login() {
        if(isset($_SESSION['account'])) {
            $this->redirect('Member/index');
        }else{
            $position[]=array('id'=>'login','catname'=>'会员登录');
            $this->seo('会员登录', '', '', $position);
            $this->display();
        }
    }
     // 登录检测
    public function checkLogin() {

        if($_SESSION['verify'] != md5($_POST['verify'])) {
            $this->error('验证码错误！');
        }
        //生成认证条件
        $map=array();
        // 支持使用绑定帐号登录
        $map['account']	= I('account');
        $map["status"]=array('eq',1);
        
        $Member=M('Member');
        $authInfo=$Member->where($map)->find();
        
        //使用用户名、密码和状态的方式进行认证
        if(false == $authInfo) {
            $this->error('用户名或密码错误！');
        }else {
            if($authInfo['password'] != md5(I('password'))) {
                $this->error('用户名或密码错误！');
            }
            $_SESSION['id']=$authInfo['id'];
            $_SESSION['account']=$authInfo['account'];
            $_SESSION['nickname']=$authInfo['nickname'];
            $_SESSION['email']=$authInfo['email'];
            $_SESSION['lastLoginTime']=$authInfo['last_login_time'];
            $_SESSION['login_count']=$authInfo['login_count'];

            //保存登录信息
            $User=M('Member');
            $ip=get_client_ip();
            $time=time();
            $data = array();
            $data['id']=$authInfo['id'];
            $data['last_login_time']=$time;
            $data['login_count']=array('exp','login_count+1');
            $data['last_login_ip']=$ip;
            $User->save($data);
          
            //$this->success('登录成功！',Cookie::get('_currentUrl_'));
            if(session('?_currentUrl_')){
                $this->success('登录成功！', session('_currentUrl_'));
            }else{
                $this->success('登录成功！', 'Member/index');
            }

        }
    }
    // 用户退出
    public function logout() {
        if(isset($_SESSION['account'])) {
            unset($_SESSION['account']);
            $this->redirect(__APP__);
        }else {
            $this->error('已经退出！');
        }
    }
     // 会员注册
    public function register() {
        if(IS_POST){
            
            if($_SESSION['verify'] != md5($_POST['verify'])) {
                $this->error('验证码错误！');
            }
            if(!preg_match('/^[a-zA-Z0-9_]{3,30}$/i',I('account'))) {
                $this->error( '用户名必须是字母、下划线、数字组成，且3位以上！');
            }
            // 创建数据对象
            $User=D("Member");
            if(!$User->create()) {
                $this->error($User->getError());
            }else{
                $User->password	=md5(I('password'));
                //写入帐号数据
                if($result =$User->add()) {
                    $this->success('注册成功！');
                }else{
                    $this->error('注册失败！');
                }
            }
        }  else {
            $position[]=array('id'=>'register','catname'=>'会员注册');
            $this->seo('会员注册', '', '', $position);
            $this->display();
        }
    }

    // 检查帐号
    public function checkAccount() {

        if(!preg_match('/^[a-zA-Z0-9_]{3,30}$/i',I('account'))) {
            $this->error( '用户名必须是字母、下划线、数字组成，且3位以上！');
        }
        
        $User = M("Member");
        //检测用户名是否冲突
        $name  =  $_REQUEST['account'];
        $result  =  $User->getByAccount($name);
        if($result) {
            $this->error('很抱歉，用户名已经存在！');
        }else {
            $this->success('恭喜您，用户名可以使用！');
        }
    }
    // 检查用户是否登录
    protected function checkUser() {
        if(!isset($_SESSION['account'])) {
            $this->assign('jumpUrl','Member/login');
            $this->error('没有登录');
        }
    }
    
    //用户资料
    public function profile() {
        $this->checkUser();
        $User=M("Member");
        $vo=$User->getById($_SESSION['id']);
        $this->assign('vo',$vo);
        $position[]=array('id'=>'profile','catname'=>'修改资料');
        $this->seo('修改资料', '', '', $position);
        $this->display();
    }
    // 修改资料
    public function change() {
        $this->checkUser();
        $id=I('id',0,'intval');
        $nickname=I('nickname');
        $email=I('email');
        
        $User=D("Member");
        $data=array(
            'nickname'=>$nickname,
            'email'=>$email,
        );
        $result	=$User->where(array('id'=>$id))->save($data);
        if(false !== $result) {
            $this->success('资料修改成功！');
        }else{
            $this->error('资料修改失败!');
        }
    }
    public function password(){
        $position[]=array('id'=>'password','catname'=>'修改密码');
        $this->seo('修改密码', '', '', $position);
        $this->display();
    }

    // 更换密码
    public function changePwd() {
	$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
        if(md5($_POST['verify'])!= $_SESSION['verify']) {
            $this->error('验证码错误！');
        }
        $map=array();
        $map['password']= pwdHash(I('oldpassword'));
        if(isset($_SESSION['id'])) {
            $map['id']=$_SESSION['id'];
        }
        //检查用户
        $User=M("Member");
        if(!$User->where($map)->field('id')->find()) {
            $this->error('输入的旧密码不正确！');
        }else {
            $User->password=pwdHash(I('password'));
            $User->save();
            $this->success('密码修改成功！');
         }
    }
    //验证码
    public function verify() {
        $type=isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }
    //用户订单查询
    public function order(){
        $map['memberid']=$_SESSION['id'];
        $Order=M('Order');
        
        import("@.ORG.Page");       //导入分页类
        $count  = $Order->where($map)->count();    //计算总数
        $Page = new Page($count, 15);
        $list   = $Order->where($map)->limit($Page->firstRow. ',' . $Page->listRows)->order('id desc')->select();
        // 设置分页显示
        $page = $Page->show();
        
        $this->page=$page;
        $this->list=$list;
        $position[]=array('id'=>'order','catname'=>'订单查询');
        $this->seo('订单查询', '', '', $position);
        $this->display();
    }
    public function orderdetail(){

        $model = M('Order');
        $id = $_REQUEST [$model->getPk()];
        $data = $model->getById($id);
        
        
        //根据ID获取产品信息
        $map['orderid']=array('eq',$data['id']);
	$Product=D("Orderdetail");
	$list=$Product->where($map)->select();
        if(is_array($list)){
            foreach ($list as $key=>$val){
                $map1['id']=array('eq',$val['proid']);
                $map1['status']=array('eq',1);
                $list[$key]['sub_list'] = D('Product')->where($map1)->find();
            }
        }
        
        $position[]=array('id'=>'order','catname'=>'订单详细');
        $this->seo('订单详细', '', '', $position);
	$this->assign('list', $list);
        $this->assign('data', $data);
        $this->display();
    }

}
?>