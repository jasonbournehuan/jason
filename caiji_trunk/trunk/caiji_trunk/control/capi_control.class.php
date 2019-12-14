<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class capi_control extends common_control {
	
	function __construct() {
		parent::__construct();
		//采集子端递交接口

		$this->api_id = core::gpc('api_id', 'P');
		$this->key = core::gpc('key', 'P');
		$this->postdata = core::gpc('data', 'P');
		$this->client = $this->mcache->read('client');
		if(empty($this->client[$this->api_id]) or $this->client[$this->api_id]['key'] != $this->key or empty($this->postdata)){
			header("HTTP/1.1 404 Not Found"); 
			exit;
		}
	}

	//获得子端递交的数据进行存储和判断
	public function on_post_data(){
		/*
		//模拟数据
		$this->api_id = 5;
		$this->postdata = '[{"code":"2,3,4","yid":6,"typeid":1,"qi":136065,"post_stuat":0,"add_time":1555935210},{"code":"1,3,4","yid":2,"typeid":1,"qi":136064,"post_stuat":0,"add_time":1555935210},{"code":"3,6,6","yid":2,"typeid":1,"qi":136063,"post_stuat":0,"add_time":1555935210},{"code":"1,6,6","yid":2,"typeid":1,"qi":136062,"post_stuat":0,"add_time":1555935210},{"code":"3,5,5","yid":2,"typeid":1,"qi":136061,"post_stuat":0,"add_time":1555935210},{"code":"2,2,4","yid":2,"typeid":1,"qi":136060,"post_stuat":0,"add_time":1555935210},{"code":"2,3,3","yid":2,"typeid":1,"qi":136059,"post_stuat":0,"add_time":1555935210},{"code":"3,4,5","yid":2,"typeid":1,"qi":136058,"post_stuat":0,"add_time":1555935210},{"code":"1,1,6","yid":2,"typeid":1,"qi":136057,"post_stuat":0,"add_time":1555935210},{"code":"2,2,2","yid":2,"typeid":1,"qi":136056,"post_stuat":0,"add_time":1555935210},{"code":"2,5,5","yid":2,"typeid":1,"qi":136055,"post_stuat":0,"add_time":1555935210},{"code":"3,5,6","yid":2,"typeid":1,"qi":136054,"post_stuat":0,"add_time":1555935210},{"code":"1,6,6","yid":2,"typeid":1,"qi":136053,"post_stuat":0,"add_time":1555935210},{"code":"1,1,6","yid":2,"typeid":1,"qi":136052,"post_stuat":0,"add_time":1555935210},{"code":"2,3,4","yid":2,"typeid":1,"qi":136051,"post_stuat":0,"add_time":1555935210},{"code":"3,3,3","yid":2,"typeid":1,"qi":136050,"post_stuat":0,"add_time":1555935210},{"code":"1,3,5","yid":2,"typeid":1,"qi":136049,"post_stuat":0,"add_time":1555935210},{"code":"4,5,6","yid":2,"typeid":1,"qi":136048,"post_stuat":0,"add_time":1555935210},{"code":"5,6,6","yid":2,"typeid":1,"qi":136047,"post_stuat":0,"add_time":1555935210},{"code":"4,4,4","yid":2,"typeid":1,"qi":136046,"post_stuat":0,"add_time":1555935210},{"code":"1,3,6","yid":2,"typeid":1,"qi":136045,"post_stuat":0,"add_time":1555935210},{"code":"2,2,3","yid":2,"typeid":1,"qi":136044,"post_stuat":0,"add_time":1555935210},{"code":"4,5,6","yid":2,"typeid":1,"qi":136043,"post_stuat":0,"add_time":1555935210},{"code":"1,2,6","yid":2,"typeid":1,"qi":136042,"post_stuat":0,"add_time":1555935210},{"code":"1,6,6","yid":2,"typeid":1,"qi":136041,"post_stuat":0,"add_time":1555935210},{"code":"3,5,5","yid":2,"typeid":1,"qi":136040,"post_stuat":0,"add_time":1555935210},{"code":"2,3,5","yid":2,"typeid":1,"qi":136039,"post_stuat":0,"add_time":1555935210},{"code":"2,3,5","yid":2,"typeid":1,"qi":136038,"post_stuat":0,"add_time":1555935210},{"code":"1,3,4","yid":2,"typeid":1,"qi":136037,"post_stuat":0,"add_time":1555935210},{"code":"3,3,5","yid":2,"typeid":1,"qi":136036,"post_stuat":0,"add_time":1555935210},{"code":"1,2,3","yid":2,"typeid":1,"qi":136035,"post_stuat":0,"add_time":1555935210},{"code":"1,2,4","yid":2,"typeid":1,"qi":136034,"post_stuat":0,"add_time":1555935210},{"code":"2,3,6","yid":2,"typeid":1,"qi":136033,"post_stuat":0,"add_time":1555935210}]';
		*/

		$data = json_decode($this->postdata, true);
        $ip = $this->za->get_ip();
        $log_file_name = BBS_PATH.'log/'.date("Y-m-d",$_SERVER['time']).'.log';
        file_put_contents($log_file_name,date("Y-m-d H:i:s",$_SERVER['time']).PHP_EOL.$ip.PHP_EOL.$this->api_id.PHP_EOL.$this->key.PHP_EOL.$this->postdata.PHP_EOL,FILE_APPEND);
		if(!empty($data)){
			//判断最大数，后面判断使用
			if($this->conf['s_num'] >= $this->conf['y_num']){
				$max_num = $this->conf['s_num'];
			}else{
				$max_num = $this->conf['y_num'];
			}

			$i = 0;
			foreach($data as $k => $v){
				$key = $v['typeid'].'-'.$v['qi'];

				$push_cache = $this->cache_redis->lPush($key, $this->api_id.'-'.$v['yid'].'-'.$v['code']);
				//$key_len = $this->cache_redis->lLen($key);

				$kj_data = array(
					'typeid' => $v['typeid'],
					'qi' => $v['qi'],
					'add_time' => $v['add_time'],
					'code' => $v['code'],
					'yid' => $v['yid'],
					'sid' => $this->api_id,
				);
			   	$this->kj->create($kj_data);

				$cache_data = $this->get_open_cache($key);

				//判断基数是否满足条件进行判断
				if(count($cache_data) >= $max_num){
					$data_list = array(
						'code' => array(),
						'service' => array(),
						'yuan' => array(),
					);

					foreach($cache_data as $ck => $cv){
						$code_info = explode("-", $cv);
						$data_list['service'][$code_info[0]] = 1;
						$data_list['yuan'][$code_info[1]] = 1;
						$data_list['code'][$code_info[2]] = 1;
					}
					$count_code = count($data_list['code']);
					if($count_code > 1){
						//多开奖号码，需要递交总端判断，先锁定数据，可能之前存在死锁情况，先检查是否需要解锁
						$lock_name = 'push_data_error_'.$v['typeid'];
						$lock_time = $this->cache_redis->kGet($lock_name);
						if(!empty($lock_time) and $lock_time <= $_SERVER['time'] - 20){
							//20秒前的属于死锁，解锁可以重新发送
							$del_lock = $this->cache_redis->del($lock_name);
						}
						//异常数据，判断发送报告给总控
						$game_push_cache = $this->cache_redis->setnx($lock_name, $_SERVER['time']);
						if(!empty($game_push_cache)){
							$check_push_log = $this->errorlog->total(array('typeid' => $v['typeid'], 'qi' => $v['qi']));
							if($check_push_log == 0){
								$check_open = $this->open->total(array('typeid' => $v['typeid'], 'qi' => $v['qi']));
								if($check_open >= 1){
									//已经开奖
									$open_status = 4;
								}else{
									$open_status = 3;
								}
								//当前期没有递交过，插入数据并最后统一发送，避免多次发送数据
								$error_data = array(
									'typeid' => $v['typeid'],
									'qi' => $v['qi'],
									'add_time' => $_SERVER['time'],
									'status' => 2,
									'infos' => $this->api_id.'||'.$v['typeid'].'||'.$v['qi'].'||'.implode('|', $data_list['code']),
									'error_typeid' => $open_status,
								);
								$add_error_log = $this->errorlog->create($error_data);
								$post_admin_error_log_stuat = 1;
							}
							$del_game_push_cache = $this->cache_redis->del($lock_name);
						}
					}else{
						//正常数据
						$count_service = count($data_list['service']);
						$count_yuan = count($data_list['yuan']);

						if($count_service >= $this->conf['s_num'] and $count_yuan >= $this->conf['y_num']){
							//满足条件开奖成功，判断是否已经开奖
							$lock_open_cache_name = 'lock_open_game_'.$v['typeid'];
							$check_open = $this->open->total(array('typeid' => $v['typeid'], 'qi' => $v['qi']));
							$lock_open_game_time = $this->cache_redis->kGet($lock_open_cache_name);
							if(!empty($lock_open_game_time) and $lock_open_game_time <= $_SERVER['time'] - 10){
								//10秒前的属于死锁，解锁可以重新发送
								$del_lock = $this->cache_redis->del($lock_open_cache_name);
							}
							$lock_open_cache = $this->cache_redis->setnx($lock_open_cache_name, $_SERVER['time']);
							if($check_open == 0 and $lock_open_cache == 1){
								//更新REDIS中单彩记录与全部记录的缓存数据与插入MYSQL数据
								$data = array(
									'typeid' => $v['typeid'],
									'qi' => $v['qi'],
									'add_time' => $_SERVER['time'],
									'code' => $v['code'],
									'up_time' => 0,
								);
								$data['id'] = $this->open->create($data);
								$push_cache1 = $this->cache_redis->lPush('game_open_'.$v['typeid'], $v['qi'].'-'.$v['code'].'-'.$_SERVER['time']);
								$push_cache2 = $this->cache_redis->lPush('open_log', $v['typeid'].'-'.$v['qi'].'-'.$v['code'].'-'.$_SERVER['time']);
								$del_game_open_cache = $this->cache_redis->del($lock_open_cache_name);
							}
						}
					}
				}
			}
		}
		if(!empty($post_admin_error_log_stuat)){
			$post_admin_msg = $this->post_admin_msg();
		}
		echo json_encode(array("status" => true,"message" => "success"));exit;
	}



}
?>