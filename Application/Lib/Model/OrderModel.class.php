<?php
class OrderModel extends CommonModel {
	// 自动验证设置
	protected $_validate	 =	 array(
            array('name','require','请填写联系人'),
            array('tel','require','请填写联系人电话'),
        );
	// 自动填充设置
	protected $_auto	 =	 array(
            
            array('ip','get_client_ip',self::MODEL_INSERT,'function'),
            array('status','2',self::MODEL_INSERT),
            array('create_time','time',self::MODEL_INSERT,'function'),
        );

}
?>