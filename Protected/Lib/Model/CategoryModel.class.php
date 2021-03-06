<?php
class CategoryModel extends CommonModel {
    // 自动验证设置
    protected $_validate=array(
        array('catname','require','分类名称必填！',1),
        array('catname','','分类已经存在',0,'unique',self::MODEL_BOTH),
    );
    
    // 自动填充设置
    protected $_auto=array(
        array('path','format_path',3,'callback'),
        array('leftset','format_leftset',3,'callback'),
        array('status','1',self::MODEL_INSERT)
    );
   function format_path(){
        $pid=isset($_POST['pid'])?(int)$_POST['pid']:0;
        if($pid==0){
            $data=0;
        }else{
            $list=$this->where("id=$pid")->find();
            $data=$list['path'].'-'.$list['id'];//子类的path为父类的path加上父类的id
        }
        return $data;
    }

    function format_leftset(){
        $leftset=isset($_POST['leftset'])?$_POST['leftset']:'';
        if(is_array($leftset) && !empty($leftset['id']) && !empty($leftset['tpl']) && !empty($leftset['lmt']) && !empty($leftset['sort'])){
            $tmp = array();
            foreach ($leftset['id'] as $key => $value) {
                $tmp[] = array('id'=>$value,'tpl'=>$leftset['tpl'][$key],'lmt'=>$leftset['lmt'][$key],'sort'=>$leftset['sort'][$key]);
            }
            return json_encode($tmp);
        }
        return $leftset;
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