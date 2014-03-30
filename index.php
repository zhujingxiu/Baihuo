<?php
if(!is_file("./config.ini.php")){
    header('Content-Type: text/html; charset=utf-8');
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
    echo "·如果你还没安装本程序，请运行<a href='install/index.php'> install/index.php 进入安装&gt;&gt; </a><br/><br/>";
    echo "&nbsp;&nbsp;<a href='http://www.yufu5.com' style='font-size:12px' target='_blank'>Powered by YUFUCMS &nbsp;企业网站系统V2.2</a>";
    exit();
}
define('APP_DEBUG',TRUE);
define('THINK_PATH', "./Core/");
define('APP_NAME', "Apps");
define('APP_PATH', "./Apps/");
require_once('360_safe3.php');//360安全防护代码
require THINK_PATH.'ThinkPHP.php';