<?php
class CategoryModel extends CommonModel {
    // 自动验证设置
    protected $_validate=array(
        array('catname','require','栏目名称必填！',1),
        array('catname','','栏目已经存在',0,'unique',self::MODEL_BOTH),
    );
    
    // 自动填充设置
    protected $_auto=array(
        array('path','tclm',3,'callback'),
        array('status','1',self::MODEL_INSERT)
    );
   function tclm(){
        $pid=isset($_POST['pid'])?(int)$_POST['pid']:0;
        if($pid==0){
            $data=0;
        }else{
            $list=$this->where("id=$pid")->find();
            $data=$list['path'].'-'.$list['id'];//子类的path为父类的path加上父类的id
        }
        return $data;
    }
    
    //获取分类菜单
    public function getMyCategory(){
        $map['status']  = array('egt',0);
        $cat=D('Category');
        $list=$cat->where($map)->field("*,concat(path,'-',id) as bpath")->order('bpath')->select();

        foreach($list as $key=>$value){
            $list[$key]['count']=count(explode('-',$value['bpath']));
        }

        return $list;
    }
    //获取分类菜单
    public function getMyCategory1() {
        //读取数据库模块列表生成菜单项   
        $node = D ( "Category" );  
        $map ['status'] =array("egt",0); 
        $list = $node->where($map)->order( 'level,listorder' )->select();  
        return $list;
    }
    //获取模型
    public function getMyModel(){
        
        $Model=D('Model');
        $mymodel=$Model->select();
        return $mymodel;
    }
    
}
?>