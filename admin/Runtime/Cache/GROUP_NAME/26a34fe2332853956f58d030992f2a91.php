<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><link rel='stylesheet' type="text/css" href="../Public/css/style.css" /><script type="text/javascript" src="../Public/js/jquery-1.7.1.min.js"></script><script type="text/javascript" src="../Public/js/common.js"></script><script type="text/javascript" src="../Public/js/jquery-yufu5.js"></script><script type="text/javascript">            $(function(){
                if($.browser.msie&&$.browser.version=="6.0"&&$("html")[0].scrollHeight>$("html").height())
                    $("html").css("overflowY","scroll");
            });
        </script><script language="JavaScript"><!--
        //指定当前组模块URL地址 
        var URL = '__URL__';
        var APP	 = '__APP__';
        var SELF='__SELF__';
        var PUBLIC='__PUBLIC__';
        var Public = '../Public/';
        //--></script><script type="text/javascript" src="../Public/ueditor/editor_config.js"></script><script type="text/javascript" src="../Public/ueditor/editor_all.js"></script></head><body><div class="main"><div class="box_tit"><h2>起始页</h2></div><div class="col"><div class="col_top">网站信息</div><div class="col_zk"><ul class="xt"><li>当前版本：鱼福CMS企业网站系统V2.2</li><li>浏览统计：今日<span>【<?php echo ($tjnum); ?>】</span>次&nbsp;昨日<span>【<?php echo ($tjnum1); ?>】</span>次&nbsp;当月<span>【<?php echo ($tjnum2); ?>】</span>次</li><li>留言信息：今日<span>【<?php echo ($lynum); ?>】</span>条&nbsp;昨日<span>【<?php echo ($lynum1); ?>】</span>条&nbsp;当月<span>【<?php echo ($lynum2); ?>】</span>条</li><li>订单信息：今日<span>【<?php echo ($ddnum); ?>】</span>个&nbsp;昨日<span>【<?php echo ($ddnum1); ?>】</span>个&nbsp;当月<span>【<?php echo ($ddnum2); ?>】</span>个</li><li>官方主站:<a href="http://www.yufu5.com" target="_blank">www.yufu5.com</a>&nbsp;&nbsp;官方备用站:<a href="http://www.yufu5.net" target="_blank">www.yufu5.net</a></li></ul><ul class="gf"></ul></div></div><div class="col"><div class="col_top">鱼福网赞助商</div><div class="col_kx"></div></div><div class="clear"></div><div class="col"><div class="col_top">鱼福网资讯</div><div class="col_ll"></div></div><div class="col"><div class="col_top">鱼福网推荐使用</div><div class="col_cp"></div></div></div><script type="text/javascript">    $.getJSON("<?php echo (session('yufu5url')); ?>/doc/zx1.php?callback=?",function(json){
        if(json.status===1){
            $(".col_zk .gf").html(json.data);
        }
    });
    $.getJSON("<?php echo (session('yufu5url')); ?>/doc/zx2.php?callback=?",function(json){
        if(json.status===1){
            $(".col_kx").html(json.data);
        }
    });
    $.getJSON("<?php echo (session('yufu5url')); ?>/doc/zx3.php?callback=?",function(json){
        if(json.status===1){
            $(".col_ll").html(json.data);
        }
    });
    $.getJSON("<?php echo (session('yufu5url')); ?>/doc/zx4.php?callback=?",function(json){
        if(json.status===1){
            $(".col_cp").html(json.data);
        }
    });

</script></body></html>