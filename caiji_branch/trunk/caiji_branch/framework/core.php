<?php
/*
	说明：
	 	该文件为框架入口，加载了核心框架类，初始化了基础数据，并且根据$_GET参数的请求，自动加载了相关文件，实例化运行。
	 	可以在命令行下运行。
	 	依赖于以下参数，测试的时候需要模拟以下参数:
	环境变量：
	 	$_SERVER
	 	$_GET
	常量：
	 	FRAMEWORK_PATH
	 	FRAMEWORK_TMP_PATH
	 	FRAMEWORK_LOG_PATH
*/

//----------------------------------> 依赖关系检查:

if(!defined('DEBUG')) {
	define('DEBUG', 1);
}

if(!defined('FRAMEWORK_PATH')) {
	define('FRAMEWORK_PATH', './');
}

if(!defined('FRAMEWORK_TMP_PATH')) {
	define('FRAMEWORK_TMP_PATH', './');
}

if(!defined('FRAMEWORK_LOG_PATH')) {
	define('FRAMEWORK_LOG_PATH', './');
}

// runtime file
if(DEBUG) {
	
	// 包含基础的类：初始化相关
	include FRAMEWORK_PATH.'lib/core.class.php';
	
	// 相对 core.class.php 不太常用的静态方法
	include FRAMEWORK_PATH.'lib/misc.class.php';
	
	// 日志，在需要的时候会被包含
	include FRAMEWORK_PATH.'lib/log.class.php';
	
	// 异常处理，依赖于 log，在需要的时候会被包含
	include FRAMEWORK_PATH.'lib/xn_exception.class.php';
	
	// db
	include FRAMEWORK_PATH.'lib/db.interface.php';
	include FRAMEWORK_PATH.'lib/db_mysql.class.php';
	include FRAMEWORK_PATH.'lib/db_mysqli.class.php';
	
	// cache
	include FRAMEWORK_PATH.'lib/cache.interface.php';
	include FRAMEWORK_PATH.'lib/cache_memcache.class.php';
	
	// 包含基础的类：初始化相关
	include FRAMEWORK_PATH.'lib/base_control.class.php';
	
	// 包含基础数据模型
	include FRAMEWORK_PATH.'lib/base_model.class.php';
	
	// 包含加密解密库
	include FRAMEWORK_PATH.'lib/encrypt.func.php';
	
	// 模板
	include FRAMEWORK_PATH.'lib/template.class.php';
	
	// socket
	//include FRAMEWORK_PATH.'lib/websocket.php';

	// Snoopy采集模块
	//include FRAMEWORK_PATH.'lib/Snoopy.class.php';
/*
	// 3des加密模块
	include FRAMEWORK_PATH.'lib/3des.class.php';

	// XML解析
	include FRAMEWORK_PATH.'lib/xml.class.php';

	// OAuth
	include FRAMEWORK_PATH.'lib/OAuth.php';

	// 二维码生成
	include FRAMEWORK_PATH.'lib/qrconst.php';
	include FRAMEWORK_PATH.'lib/qrconfig.php';
	include FRAMEWORK_PATH.'lib/qrtools.php';
	include FRAMEWORK_PATH.'lib/qrspec.php';
	include FRAMEWORK_PATH.'lib/qrimage.php';
	include FRAMEWORK_PATH.'lib/qrinput.php';
	include FRAMEWORK_PATH.'lib/qrbitstream.php';
	include FRAMEWORK_PATH.'lib/qrsplit.php';
	include FRAMEWORK_PATH.'lib/qrrscode.php';
	include FRAMEWORK_PATH.'lib/qrmask.php';
	include FRAMEWORK_PATH.'lib/qrencode.php';
	*/
} else {
	// 语义同上段，优先读取应用定义的目录下的 runtime 文件
	$content = '';
	$runtimefile = FRAMEWORK_TMP_PATH.'_runtime.php';
	if (!is_file($runtimefile)) {
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/core.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/cache_memcache.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/misc.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/log.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/xn_exception.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/base_control.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/base_model.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/encrypt.func.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/template.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/db.interface.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/cache.interface.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/db_mysql.class.php');
		$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/db_mysqli.class.php');
		//$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/websocket.php');
		//$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/db_mongodb.class.php');
		//$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/Snoopy.class.php');
		//$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/3des.class.php');
		//$content .= php_strip_whitespace(FRAMEWORK_PATH.'lib/xml.class.php');
		file_put_contents($runtimefile, $content);
		unset($content);
	}
	include $runtimefile;
}

?>