<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?></title>
<meta name="keywords" content="<?php echo ($keywords); ?>" />
<meta name="description" content="<?php echo ($description); ?>" />
<link href="../Public/css/basic.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="../Public/js/slider.js"></script>
</head>
<body class="bodybg">
    <div class="head section clearfix">
    	<a href="__APP__"><img src="__ROOT__/Uploads<?php $set=$_result=M('Set')->getField('logo',1); echo $set;?>" /></a>
        <div class="headr">
            <span class="phone">025-57324358</span>
            <a href="#">设为首页</a><a href="#">加入收藏</a><a href="#">联系我们</a>
        </div>

    </div>
    <div class="navbg">
        <div class="section">
            <ul class="nav">
                <li id="nav_0"><h3><a href="__APP__">首页</a></h3></li>
                <?php if(is_array($nav_list)): $i = 0; $__LIST__ = $nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="nav_<?php echo ($vo["id"]); ?>">
                        <h3><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["catname"]); ?></a></h3>
                        <?php if(!empty($vo["sub_nav"])): ?><div class="nav-a">
                            <?php if(is_array($vo["sub_nav"])): $i = 0; $__LIST__ = $vo["sub_nav"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><a href="<?php echo ($sub["url"]); ?>"><?php echo ($sub["catname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div><?php endif; ?>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        
    </div>
    <div class="section">
        <!-- 焦点图 -->
        <div id="DestpicFlow">
            <ul class="Slides">
                <?php $_result=M('Slide')->where('status=1')->field('id,title,url,img')->order('listorder desc')->limit(5)->select();foreach($_result as $key=>$slide):?><li style="display: none; position: absolute; top: 0pt; left: 0pt; z-index: 1; opacity: 1;">
                    <a href="<?php echo ($slide["url"]); ?>" target="_blank"><img src="__UPLOADS__<?php echo ($slide["img"]); ?>" alt="<?php echo ($slide["title"]); ?>"  width="1000"/></a>
                </li><?php endforeach;?>
            </ul>
            <ul class="SlideTriggers">
                <?php $_result=M('Slide')->where('status=1')->field('id')->order('listorder desc')->limit(5)->select();foreach($_result as $key=>$slide):?><li <?php if(($key) == "0"): ?>class="Current"<?php endif; ?>><?php echo ($key+1); ?></li><?php endforeach;?>
            </ul>
        </div>
        <script type="text/javascript">TB.widget.SimpleSlide.decorate('DestpicFlow', {eventType:'mouse', effect:'fade'});</script>
    </div>


    <div class="section ">
    	<div class="main_left">
            <div class="model">
    <div class="model_top">产品分类<span><a href="#"></a></span></div>
    <div class="model_content clearbimg">
    <ul>
        <div class="lf_tree">
        <?php $_list=D('Category')->where('status=1 and id in (37,38,39)')->field("*,concat(path,'-',id) as bpath")->order('bpath')->select();foreach($_list as $key=>$value):$_list[$key]['count']=count(explode('-',$value['bpath']));endforeach;$_result=$_list;foreach($_result as $key=>$category): if($_result[$key]['count'] == $_result[$key-1]['count'] or $_result[$key-1]['count'] == null): ?><li><a href="<?php echo U('Product/index',array('id'=>$category['id']));?>"><?php echo ($category["catname"]); ?></a></li> 
            <?php elseif($_result[$key]['count'] > $_result[$key-1]['count']): ?>
                <ul>
                <li><a href="<?php echo U('Product/index',array('id'=>$category['id']));?>"><?php echo ($category["catname"]); ?></a></li>
            <?php elseif($_result[$key]['count'] < $_result[$key-1]['count']): ?>
                </ul>
                <li><a href="<?php echo U('Product/index',array('id'=>$category['id']));?>"><?php echo ($category["catname"]); ?></a></li><?php endif; endforeach;?>
        </div>
    </ul>
    </div>
</div>
        </div>
        <div class="main_right">
        	<div class="content">
            	<div class="content_top"><?php echo ($positionname); ?></div>
                <div class="content_news">
                    <div class="title">
                    	<h2><?php echo ($data["title"]); ?></h2>
                        <div class="info"><span>发布时间：<?php echo (todate($data["create_time"],'Y-m-d')); ?></span><span>浏览&nbsp;<?php echo ($data["hits"]); ?>&nbsp;次</span></div>
                    </div>

                    <div class="clear"></div>
                    <div class="disdoc">
                    	<?php echo ($data["content"]); ?>
                    </div>
                    <div class="prev_next_nav">
                        <div class="prev">上一篇：<?php if(empty($prevdata)): ?>第一篇<?php else: ?><a href="<?php echo U('Article/show',array('id'=>$prevdata['id']));?>" target="_blank"><?php echo (msubstr($prevdata['title'],0,20)); ?></a><?php endif; ?></div>
                        <div class="next">下一篇：<?php if(empty($nextdata)): ?>最后一篇<?php else: ?><a href="<?php echo U('Article/show',array('id'=>$nextdata['id']));?>" target="_blank"><?php echo (msubstr($nextdata['title'],0,20)); ?></a><?php endif; ?></div>
                    </div>
                </div>
               
            </div>
           
        </div>
    </div>
    <div class="clear"></div>

    <!-- foot -->
	<div class="section">
        <?php $other=$_result=M('Other')->where('settag="footer"')->find(); echo $other['setvalue'];?>&nbsp;&nbsp;
    </div>
</div>


<script type="text/javascript">
$(function(){
	$(".nav li").hover(function(){
		$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
			});
	});

</script>
</body>
</html>