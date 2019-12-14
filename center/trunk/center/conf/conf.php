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
					'user' => 'prozzuser',
					'password' => '7JvvLBkNtmM8YIar',
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
			'host'=>'prod-redis.x8gykm.ng.0001.apne1.cache.amazonaws.com',
			'port'=>'6379',
			'auth'=>'',
		)
	),
	'platform' => array(
        "1" => array(
            "url" => "https://mingbo1938.fgipa.com/v3",
            "url1" => "https://mingbo1938.fgipa.net/v3",//备用
            "merchantName" => "mingbo1938",
            "merchantCode" => "a1a452b9e64ec68dd80ab8e98813edec",
        ),
        "2" => array(
            "url" => "https://api.ap761.com/igvb/",
            "url1" => "",
            "key" => "ba152bbdab1d063a9ef222d92ebfe45c",
            "agent" => "2003",
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
            "url" => "https://api.avia-gaming.com",
            "url1" => "",
            "Authorization" => "c26c71e91014430dbbf4101501ebd345",
        ),
        "5" => array(
            "url" => "https://api.ky026.com:189/channelHandle",
            "url1" => "https://record.ky026.com:190/getRecordHandle",
            "desKey" => "4553840A07A62EFF",
            "md5Key" => "340D6ECC5D359C84",
            "api_id" => "602136",
        ),
        "6" => array(
            "url" => "http://n1api.linirn.com/open-cloud/api/",
            "url1" => "",
            "sn" => "dv06",
            "secretKey" => "DD6376E93D2D4C64BAD94408166D324D",
            "uppername" => "mingbo_bg",
            "password" => "vRT9nNMA3XiKd1dpdEV4ugLdyyZg3kNF",
            "proxy_id" => "125789542",
        ),
        "7" => array(
            "url" => "http://api.dg99web.com",
            "url1" => "",
            "key" => "9da91750d57246f19132f4c5a1d2e69c",
            "agent" => "DG10090101",
        ),
        "8" => array(
            "url" => "http://transferapi.ugamingservice888.com/ThirdAPI.asmx/",
            "url1" => "http://transferapi.ugamingservice.com/ThirdAPI.asmx/",
            "secretKey" => "89bc3d42f96e90481bfdfe30d70aa3e3",
        ),
        "9" => array(
            "url" => "https://apif.cqgame.cc",
            "url1" => "",
            "token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyaWQiOiI1ZDVmNDBmM2ZhNDllODAwMDE3YTM0YzEiLCJhY2NvdW50IjoibWluZ2JvIiwib3duZXIiOiI1Y2Y3NTg3Y2Y1YWUxMzAwMDFhNjE5ZDQiLCJwYXJlbnQiOiI1Y2Y3NTg3Y2Y1YWUxMzAwMDFhNjE5ZDQiLCJjdXJyZW5jeSI6IkNOWSIsImp0aSI6Ijg0MzY5OTk4OSIsImlhdCI6MTU2NjUyMzYzNSwiaXNzIjoiQ3lwcmVzcyIsInN1YiI6IlNTVG9rZW4ifQ.MPtgSsYtvhetb02EvJ1Hp-5MXkP43yrPhE8QM8ARJ4c",

        ),
        "10" => array(
			"url" => "http://api.jdb247.net/apiRequest.do",
			"url1" => "",
			"dc" => "ZF",
			"iv" => "7d9555052d464cb2",
			"key" => "f9d5ac1dba1ded3c",
			"agent" => "mbrmbag",
			"agent_password" => "asdf1234",
        ),
        "11" => array(
			"url" => "https://legapi.leg111.com:189/channelHandle",
			"url1" => "https://legrec.leg111.com:190/getRecordHandle",
			"agent" => "72051",
			"desKey" => "B0C105645523D3E2",
			"md5Key" => "2135762EB2C7E453",
		),
		"12" => array(
            "url" => "https://api.lc8889.com:189/channelHandle",
            "url1" => "https://record.lc8889.com:190/getRecordHandle",
            "agent" => "91307",
            "desKey" => "EB4BBBA312E179F9",
            "md5Key" => "5D64FD46648C2C7E",
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
	'op' =>  0,   //0:linux 1:windows
	'redis_db' => 1,  //redis db
);
?>
