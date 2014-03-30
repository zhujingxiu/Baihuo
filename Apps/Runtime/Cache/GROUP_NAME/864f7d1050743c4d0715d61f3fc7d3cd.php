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


    <!-- 百货简介 -->
    <div class="section">
        <div class="clearfix mart10">
            <div class="boxnav">
                <h3>楼层导航</h3>
                <?php $other=$_result=M('Other')->where('settag="shopping_guide"')->find(); echo $other['setvalue'];?>
            </div>
            <div class="boxnav-r">
                <div class="jianj">
                    <h4>百货大厦简介</h4>
                    <div class="jianj-d clearfix">
                        <?php $other=$_result=M('Other')->where('settag="mini_intro"')->find(); echo $other['setvalue'];?>
                    </div>
                </div>
                <div class="index-news">
                    <h4>集团新闻</h4>
                    <ul>
                        <?php $_result=M('Article')->where('status=1 and catid in (1)')->field('id,title,create_time')->order('create_time desc')->limit(5)->select();foreach($_result as $key=>$article):?><li><em class="time"><?php echo (date("Y-m-d",$article["create_time"])); ?></em><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>"><?php echo (msubstr($article["title"],0,25)); ?></a></li><?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 精品推荐 -->
    <div class="section">
        <div class="jp-box mart10">
            <h3><a href="#" class="more">more...</a>精品推荐</h3>
            <div id="demo" style="width:978px; height:195px;overflow:hidden;">
                <?php $other=$_result=M('Other')->where('settag="manufacturer_slider"')->find(); echo $other['setvalue'];?>
            </div>
        </div>
    </div>
    <!-- 百货促销 -->
    <div class="section">
        <div class="box2 clearfix mart10">
        	<div class="cx">
                <h3><a href="<?php echo U('Article/index',array('id'=>'44'));?>" class="more" target="_blank">more</a>百货促销信息</h3>
                <div class="cx-box clearfix">
                    <p class="pic">
                        <a href="#"><img src="images/pic1.jpg" width="125" height="80" /><b>提升城市功能品质 加快美</b></a>
                    </p>
                     <ul>
                        <?php $_result=M('Article')->where('status=1 and catid in (44)')->field('id,title,create_time')->order('create_time desc')->limit(5)->select();foreach($_result as $key=>$article):?><li><em class="time"><?php echo (todate($article["create_time"],"Y-m-d")); ?></em><a href="<?php echo U('Article/show',array('id'=>$article['id']));?>" target="_blank"><?php echo (msubstr($article["title"],0,22)); ?></a></li><?php endforeach;?>
                    </ul>
                </div>
                
            </div>
            <div class="zx-dt">
                <h3><a href="#" class="more">[更多]</a>最新动态</h3>
                 <ul class="dx">                   
                    <?php $_result=M('Announce')->where('status=1 and endtime >= "2014-03-30"')->field('id,title,create_time')->order('create_time desc')->limit(5)->select();foreach($_result as $key=>$announce):?><li><em class="time"><?php echo (todate($announce["create_time"],"Y-m-d")); ?></em><a href="<?php echo U('Announce/show',array('id'=>$announce['id']));?>" target="_blank"><?php echo (msubstr($announce["title"],0,25)); ?></a></li><?php endforeach;?>
                </ul>

            </div>
        </div>
    </div>
<div class="clear"></div>
<!-- 友情链接 -->
<div class="section">
    <div class="link mart10"><i></i>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['type'] == 0 ): if($vo['linktype'] == 0): ?><a href="<?php echo ($vo["url"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></a>
            <?php else: ?>
            <a href="<?php echo ($vo["url"]); ?>" target="_blank"><img src="__ROOT__/Uploads<?php echo ($vo["logo"]); ?>" alt="<?php echo ($vo["name"]); ?>" /></a><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
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