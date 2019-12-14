<?php
$_SERVER['REQUEST_URI']="/?collection-data.htm";
$_SERVER['cron'] = 'ahk3_cpapi';
//$_SERVER['cron'] = 'ahk3_ig185';
// 调试模式: 0:关闭; 1 打开; 2: 详细调试模式;
define('DEBUG', 2);

// 站点根目录，在单元测试时候，此文件可能被包含
$file = explode("/", $_SERVER['SCRIPT_FILENAME']);
unset($file[count($file)-1]);
define('BBS_PATH', implode("/", $file).'/');

// 加载应用的配置文件，唯一的全局变量 $conf
if(!($conf = include BBS_PATH.'conf/conf.php')) {
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