<?php
    return array(
        'APP_AUTOLOAD_PATH'		=> '@.TagLib',
        'TAGLIB_PRE_LOAD'		=> 'view_block',
        'TMPL_ACTION_ERROR'		=> 'Public:error',
        'TMPL_ACTION_SUCCESS'	=> 'Public:success',
        'LOAD_EXT_CONFIG'		=> 'user',
        
        'SHOW_PAGE_TRACE' 		=>true, // 显示页面Trace信息
        'SHOW_RUN_TIME'    		=> true, // 运行时间显示
        'SHOW_ADV_TIME'    		=> true, // 显示详细的运行时间
        'SHOW_DB_TIMES'    		=> true, // 显示数据库查询和写入次数
        'SHOW_CACHE_TIMES' 		=> true, // 显示缓存操作次数
        'SHOW_USE_MEM'     		=> true, // 显示内存开销
        'SHOW_LOAD_FILE'   		=> true, // 显示加载文件数
        'SHOW_FUN_TIMES'   		=> true, // 显示函数调用次数
    );

?>