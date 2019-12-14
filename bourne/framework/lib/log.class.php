<?php

if(!isset($_SERVER['time'])) {
	$_SERVER['time'] = time();
}

if(!isset($_SERVER['time_fmt'])) {
	$_SERVER['time_fmt'] = gmdate('y-n-j H:i', $_SERVER['time'] + 86400 * 8);
}

class log {
	public static function write($s, $file = 'phperror.php') {
		$logpath = FRAMEWORK_LOG_PATH;
		$s = self::safe_str($s);
		$logfile = $logpath.$file;
		$ip = $_SERVER['ip'];
		$time = $_SERVER['time_fmt'];
		$url = $_SERVER['REQUEST_URI'];
		$url = self::safe_str($url);
		if(!error_log('<?php exit;?>'."	$time	$ip	$url	$s	\r\n", 3, $logfile)) {
			throw new Exception('写入日志失败，可能磁盘已满，或者文件'.$logfile.'不可写。');
		}
	}
	
	public static function safe_str($s) {
		$s = str_replace("\r\n", ' ', $s);
		$s = str_replace("\r", ' ', $s);
		$s = str_replace("\n", ' ', $s);
		$s = str_replace("\t", ' ', $s);
		return $s;
	}
}
?>