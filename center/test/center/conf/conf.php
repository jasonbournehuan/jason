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
					'host' => 'test-database-compose.cvj4tj0or9um.ap-northeast-1.rds.amazonaws.com',
					'user' => 'devzzuser',
					'password' => 'XoUhlvBNgmmz7aiV',
					'name' => 'center',
					'charset' => 'utf8',
					'tablepre' => 'center_',
					'engine'=>'MyISAM',
			),
			'slaves' => array (
			)
		),
		'pdo' => array (
			'master' => array (
					'host' => 'localhost',
					'user' => 'root',
					'password' => 'root',
					'name' => 'test',
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
			'host'=>'test-redis.x8gykm.0001.apne1.cache.amazonaws.com',
			'port'=>'6379',
			'auth'=>'',
		)
	),
	'platform' => array(
		"1" => array(
			"url" => "https://api.ppro.98078.net/v3",
			"url1" => "",//备用
			"merchantName" => "uat_mingbo1938",
			"merchantCode" => "196f947f9c00ee8e20af23cc0d5b5926",
		),
		"2" => array(
			"url" => "http://tapi.761city.com:10018/",
			"url1" => "",
			"key" => "ba152bbdab1d063a9ef222d92ebfe45c",
			"agent" => "1156",
			"iv" => substr('ba152bbdab1d063a9ef222d92ebfe45c',0,16),

		),
		"3" => array(
			"url" => "https://linkapi.walk168.com/app/WebService/JSON/display.php",
			"url1" => "https://888.walk168.com/app/WebService/JSON/display.php",
			"Authorization" => "f66278dad7d2431db0ae54b34c1a25f2",
			"website" => "avia",
			"uppername" => "dmingbo",
		),
		"4" => array(
			"url" => "http://testapi.bw-gaming.com",
			"url1" => "",
			"Authorization" => "1e1ef04f598d4acf87994248308a8abc",
		),
		"5" => array(
			"url" => "https://kyapi.ky206.com:189/channelHandle",
			"url1" => "https://kyrecord.ky206.com:190/getRecordHandle",
			"desKey" => "C6477B1AB2073C2B",
			"md5Key" => "D4922602C82CD582",
			"api_id" => "71622",
		),
		"6" => array(
			"url" => "http://am.bgvip55.com/open-cloud/api/",
			"url1" => "",
			"sn" => "am00",
			"secretKey" => "8153503006031672EF300005E5EF6AEF",
			"uppername" => "jason_bg",
			"password" => "2827350",
			"proxy_id" => "111690928",
		),
		"7" => array(
			"url" => "http://api.dg99web.com",
			"url1" => "",
			"key" => "fef7f315f2e44697b3396aef500c95f2",
			"agent" => "DGTE0101D3",
		),
		"8" => array(
			"url" => "http://transferapi.ugamingservice888.com/ThirdAPI.asmx/",
			"url1" => "http://transferapi.ugamingservice.com/ThirdAPI.asmx/",
			"secretKey" => "65d9802d894b1535037653d96811f31b",
		),
		"9" => array(
			"url" => "https://apif.cqgame.cc",
			"url1" => "",
			"token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyaWQiOiI1ZDVmNDBmM2ZhNDllODAwMDE3YTM0YzEiLCJhY2NvdW50IjoibWluZ2JvIiwib3duZXIiOiI1Y2Y3NTg3Y2Y1YWUxMzAwMDFhNjE5ZDQiLCJwYXJlbnQiOiI1Y2Y3NTg3Y2Y1YWUxMzAwMDFhNjE5ZDQiLCJjdXJyZW5jeSI6IkNOWSIsImp0aSI6Ijg0MzY5OTk4OSIsImlhdCI6MTU2NjUyMzYzNSwiaXNzIjoiQ3lwcmVzcyIsInN1YiI6IlNTVG9rZW4ifQ.MPtgSsYtvhetb02EvJ1Hp-5MXkP43yrPhE8QM8ARJ4c",

		),
		"10" => array(
			"url" => "http://api.jygrq.com/apiRequest.do",
			"url1" => "",
			"dc" => "ZF",
			"iv" => "193a3159afebee65",
			"key" => "831057181dd07807",
			"agent" => "mbagent",
			"agent_password" => "asdf@1234",
		),
		"11" => array(
			"url" => "https://csapi.leg111.com:189/channelHandle",
			"url1" => "https://csrecod.leg111.com:190/getRecordHandle",
			"agent" => "200496",
			"desKey" => "6DE5165D4455C1ED",
			"md5Key" => "EAD38B379D40F265",
		),
        "12" => array(
            "url" => "https://demoapi.lc8889.com:189/channelHandle",
            "url1" => "https://demorecord.lc8889.com:190/getRecordHandle",
            "agent" => "61307",
            "desKey" => "DA6D53D9E176002B",
            "md5Key" => "6E44A357F3B16C7B",
        ),
	),
	// 唯一识别ID
	'app_id' => 'center',
	
	// 站点名称
	'app_name' => '',
	
	// 站点介绍
	'app_brief' => '',
		
	// 应用的路径，用于多模板互相包含，需要时，填写绝对路径： 如: http://www.domain.com/
	'app_url' => 'http://127.0.0.1/center/',
	
	// CDN 缓存的静态域名，如 http://static.domain.com/
	'static_url' => 'http://127.0.0.1/center/',
	
	// 模板使用的目录，按照顺序搜索，这样可以支持风格切换,结果缓存在 tmp/yhq_xxx_control.htm.php
	'view_path' => array(BBS_PATH.'plugin/view_blue/', BBS_PATH.'view/'), 
	
	// 数据模块的路径，按照数组顺序搜索目录
	'model_path' => array(BBS_PATH.'model/'),
	
	// 业务控制层的路径，按照数组顺序搜索目录，结果缓存在 tmp/bbs_xxx_control.class.php
	'control_path' => array(BBS_PATH.'control/'),
	
	// 临时目录，需要可写，可以指定为 linux /dev/shm/ 目录提高速度
	'tmp_path' => BBS_PATH.'tmp/',
	
	// 缓存目录，需要可写，可以指定为 linux /dev/shm/ 目录提高速度
	'cache_path' => BBS_PATH.'cache/',
	
	// 上传目录，需要可写，保存用户上传数据的目录
	'upload_path' => BBS_PATH.'upload/',

	// 各种文件锁的保存路径
	'lock_path' => BBS_PATH.'lock/',
	
	// 锁类型，1为memcache，其他为文件锁
	'lock_type' => 2,
	
	// 模板的URL，用作CDN时请填写绝对路径，需要时，填写绝对路径： 如: http://www.domain.com/upload/
	'upload_url' => 'http://127.0.0.1/caipiao/upload/',
	
	// 日志目录，需要可写，如果您不需要日志，留空即可
	'log_path' => BBS_PATH.'log/',
		
	'plugin_path' => BBS_PATH.'plugin/',
	
	// 是否开启 URL-Rewrite
	'urlrewrite' => 0,
	
	'timeoffset' => '-8',
	'cookie_keeptime' => 86400,
	'shiwu' => 1,//事务模式，1为程序事务，2为数据库事务
	'table_site_num' => 50,//50个表循环全部数据
	'op' =>  0, //0:linux 1:windows
	'redis_db' => 1, //redis db
);
?>
