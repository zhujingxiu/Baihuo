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
        //--></script><script type="text/javascript" src="../Public/ueditor/editor_config.js"></script><script type="text/javascript" src="../Public/ueditor/editor_all.js"></script></head><body><div class="main"><div class="box_tit"><h2>系统设置</h2></div><div class="form_list"><form method='post' id="form1" name="form1" action="<?php echo U('Set/save');?>"  enctype="multipart/form-data"><div class="form_list_top"><dl><dt> 站点名称：</dt><dd><input type="text" class="ipt6" name="SITE_NAME" value="<?php echo ($user_config["SITE_NAME"]); ?>"><strong class="red">*</strong></dd></dl><dl><dt> 站点标题：</dt><dd><input type="text" class="ipt6" name="SITE_TITLE" value="<?php echo ($user_config["SITE_TITLE"]); ?>"><span class="fontcolor">站点首页title标签的设置</span></dd></dl><dl><dt> 站点关键词：</dt><dd><input type="text" class="ipt6" name="SITE_KEYWORDS" value="<?php echo ($user_config["SITE_KEYWORDS"]); ?>"><span class="fontcolor">站点首页meta标签 keywords站点关键词的设置</span></dd></dl><dl><dt> 站点描述：</dt><dd><textarea name="SITE_DESCRIPTION" style="width:400px; height:60px; padding-left: 3px;"><?php echo ($user_config["SITE_DESCRIPTION"]); ?></textarea><span class="fontcolor">站点首页meta标签 description站点描述的设置</span></dd></dl><dl><dt> 站点logo：</dt><dd><?php if(!empty($set["logo"])): ?><img src="__UPLOADS__<?php echo ($set["logo"]); ?>" name="logo" class="logo" /><a href="javascript:;" onclick="foreverdelthumb(this);" title="你确定要删除logo吗？">删除logo</a><?php else: ?><input type="file" class="thumb" name="logo" /><?php endif; ?></dd></dl><dl><dt> 微信二维码：</dt><dd><?php if(!empty($user_config["WX_QRCODE"])): ?><img src="__UPLOADS__<?php echo ($user_config["WX_QRCODE"]); ?>"  class="wxqrcode" /><a href="javascript:;" onclick="delfile('__UPLOADS__<?php echo ($user_config["WX_QRCODE"]); ?>');" title="你确定要删除微信二维码吗？">删除微信二维码</a><?php else: ?><input type="file" class="thumb" name="WX_QRCODE" /><?php endif; ?></dd></dl><dl><dt> 模板设置：</dt><dd><select name="DEFAULT_THEME"><?php if(is_array($templateList)): $i = 0; $__LIST__ = $templateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php echo ($key==$user_config['DEFAULT_THEME'] ? 'selected="selected"':''); ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></dd></dl><dl><dt> 后台最大登录失败次数：</dt><dd><input type="text" class="ipt2" name="errorcount" value="<?php echo ($set["errorcount"]); ?>"><span class="fontcolor">后台最大登录失败次数</span></dd></dl><dl><dt> 后台登录失败超次后间隔：</dt><dd><input type="text" class="ipt2" name="errorinterval" value="<?php echo ($set["errorinterval"]); ?>"><span class="fontcolor">后台登录超过设置的最大失败超次后需要等待间隔（秒）</span></dd></dl><dl><dt> 留言间隔：</dt><dd><input type="text" class="ipt2" name="messageinterval" value="<?php echo ($set["messageinterval"]); ?>"><span class="fontcolor">用户留言间隔（秒）</span></dd></dl></div><div class="form_b"><input type="hidden" name="id" value="<?php echo ($set["id"]); ?>"><input type="submit" class="submit btn7" id="submit" value="提 交"></div></form></div></div><script type="text/javascript">    function delfile(url){
       
        if(is_file($src)){
            unlink($src);
            //插入新节点
            var html='<dd>\r\n<input type="file" class="thumb" name="WX_QRCODE" />\r\n</dd>';
            $(cur).parent().after(html);

            //移除当前节点
            $(cur).parent().remove();
        }
            

    }
   function foreverdelthumb(cur){
       var nodename=$(cur).prev().attr('name');
       var url="<?php echo U('Set/delfile',array('id'=>$set['id'],'file'=>'"+nodename+"'));?>";
        //创建删除节点
        $.get(url,function(){
            //插入新节点
            var html='<dd>\r\n<input type="file" class="thumb" name="'+nodename+'" />\r\n</dd>';
            $(cur).parent().after(html);

            //移除当前节点
            $(cur).parent().remove();
        });
    }
</script></body></html>