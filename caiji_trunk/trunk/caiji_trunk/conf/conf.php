<?php
 
/**************************************************************************************************
 *
 *	【注意】：
 *		请不要使用 Windows 的记事本编辑此文件！此文件的编码为UTF-8编码，不带有BOM头！
 *		建议使用UEStudio, Notepad++ 类编辑器编辑此文件！
 *
***************************************************************************************************/

// 全局配置变量

return array (
	
	// 数据库配置， type 为默认的数据库类型，可以支持多种数据库: mysql|pdo|mongodb
	'db' => array (
		'type' => 'mysqli',
		'mysqli' => array (
			'master' => array (
					'host' => 'prod-database-compose.cvj4tj0or9um.ap-northeast-1.rds.amazonaws.com',
					'user' => 'prozduser',
					'password' => 'okbtZjkSVETMLrEb',
					'name' => 'caiji_trunk',
					'charset' => 'utf8',
					'tablepre' => 'cj_',
					'engine'=>'MyISAM',
			),
			'slaves' => array (
			)
		),
		'pdo' => array (
			'master' => array (
					'host' => 'prod-database-compose.cvj4tj0or9um.ap-northeast-1.rds.amazonaws.com',
					'user' => 'prozduser',
					'password' => 'okbtZjkSVETMLrEb',
					'name' => 'caiji_trunk',
					'charset' => 'utf8',
					'tablepre' => '',
					'engine'=>'MyISAM',
			),
			'slaves' => array (
			)
		),
		'mongodb' => array(
			'master' => array (
					'host' => '10.0.0.253:27017',
					'user' => '',
					'password' => '',
					'name' => 'test',
					'tablepre' => '',
			),
			'slaves' => array (
			)
		),
	),	
	'cache_colse' => 0,
	// 缓存服务器的配置，支持: memcache|ea|apc|redis
	'cache' => array (
		'enable'=>0,
		'type'=>'redis',
		'redis'=>array (
			'multi'=>0,
			'host'=>'prod-redis.x8gykm.ng.0001.apne1.cache.amazonaws.com',
			'port'=>'6379',
			'auth'=>'',
		)
	),

	// 唯一识别ID
	'app_id' => 'api',
	
	// 站点名称
	'app_name' => 'api',
	
	// 站点介绍
	'app_brief' => '',
		
	// 应用的路径，用于多模板互相包含，需要时，填写绝对路径： 如: http://www.domain.com/
	'app_url' => 'http://127.0.0.1/caipiaocj_server/',
	
	// CDN 缓存的静态域名，如 http://static.domain.com/
	'static_url' => 'http://127.0.0.1/caipiaocj_server/',
	
	// 模板使用的目录，按照顺序搜索，这样可以支持风格切换,结果缓存在 tmp/yhq_xxx_control.htm.php
	'view_path' => array(BBS_PATH.'plugin/view_blue/', BBS_PATH.'view/'), 
	
	// 数据模块的路径，按照数组顺序搜索目录
	'model_path' => array(BBS_PATH.'model/'),
	
	// 业务控制层的路径，按照数组顺序搜索目录，结果缓存在 tmp/bbs_xxx_control.class.php
	'control_path' => array(BBS_PATH.'control/'),
	
	// 临时目录，需要可写，可以指定为 linux /dev/shm/ 目录提高速度
	'tmp_path' => BBS_PATH.'tmp/',
	
	// 上传目录，需要可写，保存用户上传数据的目录
	'upload_path' => BBS_PATH.'upload/',
	
	// 缓存目录，需要可写，可以指定为 linux /dev/shm/ 目录提高速度
	'cache_path' => BBS_PATH.'cache/',
	
	// 模板的URL，用作CDN时请填写绝对路径，需要时，填写绝对路径： 如: http://www.domain.com/upload/
	'upload_url' => 'http://127.0.0.1/caipiaocj_server/upload/',
	
	// 日志目录，需要可写，如果您不需要日志，留空即可
	'log_path' => BBS_PATH.'log/',
		
	'plugin_path' => BBS_PATH.'plugin/',
	
	'cookiepre'=> 'api_',
	
	// 是否开启 URL-Rewrite
	'urlrewrite' => 0,
	
	// 加密KEY，
	'public_key' => '972b27859503eed43edea25b09264404',
	
	'timeoffset' => '-8',
	'cookie_keeptime' => 86400,

	'api_version' => '1.02',
	'cron_error_no' => '5',
	'admin_api_url' => 'http://127.0.0.1/cjadmin/api.php',
	'admin_api_key' => 'jsaiiasdn',
	'admin_heartbeat_url' => 'http://127.0.0.1/cjadmin/heartbeat.php',

	'y_num' => '2',//确认开奖结果必须达到的同结果源数量
	's_num' => '5',//确认开奖结果必须达到的同结果服务器数量
);
?>
