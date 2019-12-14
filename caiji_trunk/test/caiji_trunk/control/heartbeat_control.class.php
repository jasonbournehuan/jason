<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class heartbeat_control extends common_control {
	
	function __construct() {
		parent::__construct();
	}

	//检查是否需要发送心跳，每分钟发送一次
	public function on_api(){
		$cache_name = 'heartbeat';
		$cache_time = $this->cache_redis->kGet($cache_name);
		if(empty($cache_time) or $cache_time < $_SERVER['time'] - 30){
			echo $this->heartbeat();
			exit;
		}else{
			echo $this->on_echo('一分钟内部重复发送心跳，上次心跳时间：'.date("Y-m-d H:i:s", $cache_time));
			exit;
		}
	}
}
?>