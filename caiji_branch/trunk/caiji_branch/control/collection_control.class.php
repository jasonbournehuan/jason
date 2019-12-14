<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class collection_control extends common_control {
	
	function __construct() {
		parent::__construct();
	}

	//采集数据
	public function on_data(){
		$date = date("m-d H:i:s", $_SERVER['time']);
        $int_time = intval(date("Hi", $_SERVER['time']));
		if($int_time <= 1 || $int_time >= 2359){
            $this->on_echo($date."23:59至01分不采集任务\r\n");
        }
		$cron_file = BBS_PATH.'collection/'.$_SERVER['cron'].'.cron.php';
		if(!is_file($cron_file)){
			$this->on_echo($date." 采集任务".$_SERVER['cron']."不存在！\r\n");
		}else{
			$task_stuat = intval($this->cache_redis->kGet($_SERVER['cron']));
			$data = array();
			include $cron_file;
			if(!empty($data)){
				if($task_stuat >= 1){
					$this->cache_redis->kSet($_SERVER['cron'], 0);
				}
				$this->check_data($typeid, $data, $yid);
				//print_r($data);
				$this->on_echo($date." 采集任务".$_SERVER['cron'].'-'.$cron_name."采集完成！\r\n");
			}else{
				$task_stuat += 1;
				$this->cache_redis->kSet($_SERVER['cron'], $task_stuat);
				if($task_stuat == intval($this->conf['cron_error_no'])){
					$post_admin_msg = $this->post_admin_msg(1, $_SERVER['cron']);//告知总后台采集子端连续多次无法抓取到页面，检查采集规则或服务器IP是否被采集源封禁
					if($post_admin_msg != 1){
						$this->on_echo($date." 发送采集任务".$_SERVER['cron'].'-'.$cron_name."错误数据失败！\r\n");
					}
				}

				$this->on_echo($date." 采集任务".$_SERVER['cron'].'-'.$cron_name."第".$task_stuat."次未采集到数据！\r\n");
			}
		}
	}
}
?>