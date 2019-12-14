<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class client_control extends common_control {
	
	function __construct() {
		parent::__construct();
	}

	//返回奖期数据
	public function on_api(){
		$data = array();
		$end_time = intval(core::gpc('end_time', 'P'));
		$cache_name = 'open_log';
		$key_len = $this->cache_redis->lLen($cache_name);
		//如果缓存数据少于100条，则从数据库查询，否则查询缓存数据
		if($key_len < 100){
			$data_list = $this->open->index_fetch(array('up_time' => array('>' => $end_time)), array('up_time' => 1), 0, 1000);
			foreach($data_list as $k => $v){
				$data[] = array(
					'game_id' => $v['typeid'],
					'qihao' => $v['qi'],
					'code' => $v['code'],
					'up_time' => $v['up_time'],
				);
			}
		}else{
			$cache_data = $this->cache_redis->lRange($cache_name, 0, 1000);
			krsort($cache_data);
			foreach($cache_data as $k => $v){
				$code_info = explode("-", $v);
				if($code_info[3] > $end_time){
					$data[] = array(
						'game_id' => $code_info[0],
						'qihao' => $code_info[1],
						'code' => $code_info[2],
						'up_time' => $code_info[3],
					);
				}
			}
		}
		echo json_encode(array('status' => 1, 'data' => $data));
		exit;
	}
}
?>