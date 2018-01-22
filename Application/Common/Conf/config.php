<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'mysql',
    'DB_HOST'=>'bdm321280383.my3w.com',
    'DB_NAME'=>'bdm321280383_db',
    'DB_USER'=>'bdm321280383',
    'DB_PWD'=>'dreamFlower',
    'DB_PREFIX'=>'ks_',
    'DB_CHARSET'=>'UTF8',
     //开启session
    'SESSION_AUTO_START' => true, 
    //url重写
     //调试
     'SHOW_PAGE_TRACE'=> false, 
     'URL_MODEL' => '2',      
     //许可的模块
     'MODULE_ALLOW_LIST' => array('Home','Back'), 
     //默认模块
     'DEFAULT_MODULE' => 'Home',
     //url不区分大小写 case_insensitive
     'URL_CASE_INSENSITIVE' =>true,   
);
// return array(
//     //'配置项'=>'配置值'
//     'DB_TYPE'=>'mysql',
//     'DB_HOST'=>'localhost',
//     'DB_NAME'=>'ks_online',
//     'DB_USER'=>'root',
//     'DB_PWD'=>'long',
//     'DB_PREFIX'=>'ks_',
//     'DB_CHARSET'=>'UTF8',
//      //开启session
//     'SESSION_AUTO_START' => true, 
//      //调试
//     'SHOW_PAGE_TRACE'=> true, 
//     //url重写
//      'URL_MODEL' => '2',      
//      //许可的模块
//      'MODULE_ALLOW_LIST' => array('Home','Back'), 
//      //默认模块
//      'DEFAULT_MODULE' => 'Home',
//      //url不区分大小写 case_insensitive
//      'URL_CASE_INSENSITIVE' =>true,   
// );