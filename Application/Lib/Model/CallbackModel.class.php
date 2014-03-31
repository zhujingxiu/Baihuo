<?php
class CallbackModel extends CommonModel {
    // 自动验证设置
    protected $_validate	 =	 array(
        array('tel','require','固话或手机号必填'),

    );
    
}
?>