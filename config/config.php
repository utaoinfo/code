<?php
return array(
	'logs'=>array(
		'path'=>'logs/log',
		'type'=>'file'
	),
	'DB'=>array(
		'type'=>'mysql',
        'tablePre'=>'ut_',
		'read'=>array(
			array('host'=>'localhost:3306','user'=>'root','passwd'=>'admin','name'=>'utao'),
		),

		'write'=>array(
			'host'=>'localhost:3306','user'=>'root','passwd'=>'admin','name'=>'utao',
		),
	),
	'langPath' => 'language',
	'viewPath' => 'views',
    'classes' => 'classes.*',
    'rewriteRule' =>'url',
	'theme' => 'default',		//主题
	'skin' => 'default',		//风格
	'timezone'	=> 'Etc/GMT-8',
	'upload' => 'upload',
	'dbbackup' => 'backup/database',
	'safe' => 'cookie',
	'safeLevel' => 'none',
	'lang' => 'zh_sc',
	'debug'=> false,
	'configExt'=> array('site_config'=>'config/site_config.php'),
	'encryptKey'=>'3dc6d57b24120128e849511c13fa36de',
);
?>