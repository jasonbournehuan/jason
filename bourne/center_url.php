<?php
set_time_limit(500);
// 调试模式: 0:关闭; 1 打开; 2: 详细调试模式;
//以后的 统一入口文件
define('DEBUG', 2);
// 站点根目录，在单元测试时候，此文件可能被包含
//define('BBS_PATH', str_replace('\\', '/', getcwd()).'/');	// iis 6 + php5.2 getcwd() 返回错误地址
$file = explode("/", $_SERVER['PHP_SELF']);
$filesubstr = strlen($file[count($file) - 1]);
define('BBS_PATH', str_replace('\\', '/', substr(__FILE__, 0, -$filesubstr)));
// 加载应用的配置文件，唯一的全局变量 $conf
if(!($conf = include BBS_PATH.'conf/conf.php')) {
	header('Location:install/');
	exit;
}

// 框架的物理路径
define('FRAMEWORK_PATH', BBS_PATH.'framework/');

// 临时目录
define('FRAMEWORK_TMP_PATH', $conf['tmp_path']);

// 日志目录
define('FRAMEWORK_LOG_PATH', $conf['log_path']);

// 包含核心框架文件，转交给框架进行处理。
include FRAMEWORK_PATH.'core.php';
core::init();
core::ob_start();
core::run();

// 完毕

?>