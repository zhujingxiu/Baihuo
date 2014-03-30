<?php
if(!defined('THINK_PATH')) exit();
return $array = array (
  'DB_TYPE' => 'mysql',
  'DB_HOST' => 'localhost',
  'DB_NAME' => 'baihu',
  'DB_USER' => 'root',
  'DB_PWD' => '',
  'DB_PORT' => '3306',
  'DB_PREFIX' => 'bh_',
  'DB_BACKUP' => '../Data/backup',
  'RBAC_ROLE_TABLE' => 'bh_role',
  'RBAC_USER_TABLE' => 'bh_user',
  'RBAC_ACCESS_TABLE' => 'bh_access',
  'RBAC_NODE_TABLE' => 'bh_node',
  'URL_CASE_INSENSITIVE' => true,
  'SITE_NAME' => '百货大楼',
  'SITE_TITLE' => '百货大楼企业网站系统',
  'SITE_KEYWORDS' => '百货大楼 CMS系统',
  'SITE_DESCRIPTION' => '百货大楼企业网站系统，针对个人完全开源免费。',
  'URL_MODEL' => 0,
  'DEFAULT_THEME' => 'default',
  'WX_QRCODE' => NULL,
);
?>