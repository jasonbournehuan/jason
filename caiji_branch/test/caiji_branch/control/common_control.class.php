<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

class common_control extends base_control {
	// 为了避免与 model 冲突，加下划线分开
	public $_sid = '';		// session id
	public $_user = array();	// 全局 user
	public $_admin = array();	// 全局 admin
	public $_dev = array();	// 全局 dev
	public $admin_system = array();	// 全局 admin_system
	
	// 计划任务
	protected $_cron_1_run = 0;	// 计划任务1 是否被激活, 15 分钟执行一次
	protected $_cron_2_run = 0;	// 计划任务2 是否被激活, 每天0点执行一次
	
	// hook common_control_before.php
	
	// 初始化 _sid, _user, _title, _nav
	function __construct() {
		// hook common_control_construct_before.php
		parent::__construct();
		// hook common_control_construct_after.php
		$this->init_timezone();
		// hook common_control_init_after.php
	}
	
	private function init_timezone() {
		//print_r($this->cache_redis->lRange('cron_1', 0, -1));exit;
		//$this->cache_redis->del('more_post_status');exit;
		//print_r($this->cache_redis->kGet('more_post_status'));exit;
		// 不需要设置，使用gmdate()
		$offset = $this->conf['timeoffset'];
		if($offset) {
			date_default_timezone_set('Etc/GMT'.$offset);
		}
		
		// 今日凌晨0点的开始时间！
		$_SERVER['time_fmt'] = gmdate('Y-n-d H:i', $_SERVER['time'] + $offset * 3600);			// +8 hours
		$arr = explode(' ', $_SERVER['time_fmt']);
		list($y, $n, $d) = explode('-', $arr[0]);
		$_SERVER['time_today'] = gmmktime(0, 0, 0, $n, $d, $y) - $offset * 3600;	// -8 hours
		
		// hook common_control_init_timezone_after.php
	}

	//检测是否通过安全验证
	private function check_safecode() {
		$this->userlang = $lang = core::gpc('lang', 'P');
		$safecode = trim(core::gpc('safecode', 'P'));
		$this->appid = $appid = intval(core::gpc('appid', 'P'));
		$version = trim(core::gpc('version', 'P'));
		$this->imei = $imei = trim(core::gpc('imei', 'P'));
		$this->devicecode = $devicecode = trim(core::gpc('devicecode', 'P'));
		$userid = intval(core::gpc('userid', 'P'));
		$usercode = trim(core::gpc('usercode', 'P'));
		$system = intval(core::gpc('system', 'R'));
		/*
		$appid = 1;
		$version = "1.0.1";
		$safecode = "87c6415e08b4eb611db262529f501914";
		$userid = 1;
		$usercode = "a8f58f4128a85eb8ca827a2b5d6d4496";
		*/
		if($system != 1){
			if(!empty($appid)){
				$this->appinfo = $appinfo = $this->ylc->get($appid);
				if(empty($appinfo) or $appinfo['stuat'] != 1){
					$this->appinfo = $appinfo = $this->ylc->index_fetch(array('stuat' => 1, 'tg' => 1), array('id' => 1));
					if(!empty($appinfo)){
						$msg = array(
							'status' => 3,
							'url' => $appinfo['url'],
						);
					}else{
						$msg = array(
							'status' => 2,
							'msg' => $this->lang['fuwuqiweihuzhong'],//服务器维护中
						);
					}
				}else if($appinfo['version'] != $version){
					$msg = array(
						'status' => 3,
						'url' => $appinfo['url'],
					);
				}else if(empty($lang)){
					$langfile = BBS_PATH.'lang/'.$lang.'.php';
					if(!file_exists($langfile)){
						$langfile = BBS_PATH.'lang/'.$appinfo['lang'].'.php';
						include $langfile;
					}
				}
			}else{
				$msg = array(
					'status' => 2,
					'msg' => $this->lang['canshucuowu'],//参数错误
				);
			}
			if(!empty($msg)){
				echo json_encode($msg);
				exit;
			}
			if(core::gpc('1', 'G') != "loading"){
				if($safecode != md5($appid.$imei.$devicecode.date("Y", $_SERVER['time']).date("m", $_SERVER['time']).date("d", $_SERVER['time']))){
					$msg = array(
						'status' => 2,
						'msg' => $this->lang['feifacaozuo'],//非法操作
					);
					echo json_encode($msg);
					exit;
				}
			}
			if(!empty($userid)){
				$upuser = 0;
				$this->_user = $user = $this->user->get($userid);
				if(!empty($user)){
					if(md5($user['id'].$this->conf['usercode'].$user['password']) != $usercode){
						$msg = array(
							'status' => 4,
							'msg' => $this->lang['mimayixiugaiqingchongxindenglu'],//密码已被修改，请重新登陆
						);
					}else if($user['ylcid'] != $appid){
						$msg = array(
							'status' => 2,
							'msg' => $this->lang['yonghubucunzaiqingquerenzhanghaomimazhengque'],//用户不存在，请确认账号密码正确！
						);
					}else{
						if(!empty($imei)){
							$upuser = 1;
							$user['imei'] = $imei;
						}
						if(!empty($devicecode)){
							$upuser = 1;
							$user['devicecode'] = $devicecode;
						}
						if(!empty($upuser)){
							$this->_user = $user;
							$upuserstuat = $this->user->update($user['id'], $user);
						}
					}
				}else{
					$msg = array(
						'status' => 4,
						'msg' => $this->lang['qingchongxindenglu'],//请重新登陆
					);
				}
			}
			if(!empty($msg)){
				echo json_encode($msg);
				exit;
			}
		}
	}
	
	private function init_cron() {
	}
	
	/*
	 * 功  能：
	 * 	提示单条信息
	 *  
	 * 用  法：
		 $this->message('站点维护中，请稍后访问！');
		$this->message('提交成功！', TRUE, '?forum-index-123.htm');
		$this->message('校验错误！', FALSE);
	 */
	public function message($message, $status = 1, $goto = '') {
		
		// hook common_control_message_before.php
		
		if(core::gpc('ajax', 'R')) {
			// 可能为窗口，也可能不为。
			$json = array('servererror'=>'', 'status'=>$status, 'message'=>$message);
			echo core::json_encode($json);
			exit;
		} else {
			$this->view->assign('message', $message);
			$this->view->assign('status', $status);
			$this->view->assign('goto', $goto);
			$this->view->display('message.htm');
			exit;
		}
	}
	
	/*
	 * 功  能：
	 * 	提示错误或者警告或者正常信息
	 *  
	 * 用  法：
		$error = array(
			'stuat' = 1,//状态，1为成功，2为失败，3为警告
			'info' = '充值成功！',//状态内容，例如：充值成功！
		);
		$this->error($error);
	 */
	public function error($error) {
		if($error['stuat'] == 1){
			$error['stuat'] = "success";
		}else if($error['stuat'] == 2){
			$error['stuat'] = "error";
		}else if($error['stuat'] == 3){
			$error['stuat'] = "warning";
		}else{
			$error['stuat'] = "error";
		}
		$this->view->assign('error', $error);
		$this->view->display('msg.htm');
		exit;
	}
	
	// relocation
	public function location($url) {
		header("Location: ".$url);
		exit;
	}
	
	public function form_submit() {
		// hook form_submit_after.php
		return misc::form_submit($this->conf['public_key']);
	}
	
	// --------------------------> 权限相关和公共的方法
	
	protected function check_msg() {
		if(!empty($this->_admin["id"])){
			$msgstuat = $msgnum = 0;
			$systemmsg = $this->admins->systemmsg();
			if(count($systemmsg) >= 1){
				$msgnum = count($systemmsg);
				$msgstuat = 1;
			}
			$this->view->assign('systemmsg', $systemmsg);
			$this->view->assign('msgstuat', $msgstuat);
			$this->view->assign('msgnum', $msgnum);
		}
	}
	
	//发送数据到采集主端
	protected function post_data($data, $num = 1) {
		if($num > 5){
			return 2;
		}
		$post_stuat = 0;
		$post_url = $this->conf['api_url'];
		$post = array(
			'api_id' => $this->conf['api_id'],
			'key' => $this->conf['api_key'],
			'data' => json_encode($data),
		);
		$results = json_decode($this->za->curlPost($post_url, $post, 3, 20),true);
		if(!empty($results['status']) and $results['status'] == 1){
			return 1;
		}else{
			$num += 1;
			return $this->post_data($data, $num);
		}
	}
	
	//发送错误到总后台
	protected function post_admin_msg($error_id, $error_cron, $num = 1) {
		if($num > 5){
			return 2;
		}
		$error_list = array(
			1 => $error_cron.'采集失败多次，请检查！',
			2 => $error_cron.'号采集子端多次递交主端失败，请检查！',
		);
		$post_stuat = 0;
		$post_url = $this->conf['admin_api_url'];
		$post = array(
			'api_id' => $this->conf['api_id'],
			'key' => $this->conf['admin_api_key'],
			'error_id' => $error_id,
			'error_info' => $error_list[$error_id],
		);
		$results = json_decode($this->za->curlPost($post_url, $post, 3, 5));
		if(!empty($results['stuat']) and $results['stuat'] == 1){
			return 1;
		}else{
			$num += 1;
			return $this->post_admin_msg($error_id, $error_cron, $num);
		}
	}
	
	//更新全局缓存
	protected function up_caipiao_cache() {
		$data_list = array();
		$data = $this->kj->group(array('id' => array('>=' => 1)), 'typeid', array('typeid', 'max(qi) as qihao'));
		if(!empty($data)){
			foreach($data as $k => $v){
				$data_list[$v['typeid']] = $v['qihao'];
			}
			$add_cache = $this->mcache->diysave('caiji', $data_list);
		}
	}
	
	//采集数据入库
	protected function add_data($data) {
		$add_list = $this->kj->add_list($data);
		$up_cache = $this->up_caipiao_cache();
		return 1;
	}

	public function on_echo($info) {
		$op = $this->conf['op'];
		if($op == '0'){
			echo $info;
		}else if($op == '1'){
			echo iconv("UTF-8", "GB2312//IGNORE", $info);
		}
	}

	//检测数据是否在缓存中，没有则表示为新数据，入库并递交
	public function check_data($game_id, $arr, $yid) {
		if(empty($arr)){
			return 1;
		}
		$key = 'cron_'.$game_id."_".$yid;
		//校验数据中是存在未保存数据
		$new_data = array();
		$cache_data = $this->cache_redis->lRange($key, 0, -1);
		$cache_data = array_flip($cache_data);
		foreach($arr as $k => $v){
			if(!isset($cache_data[$k.'-'.$v['haoma']])){
				//未记录的数据
				$new_data_code = $k.'-'.$v['haoma'];
				$new_data[] = array(
					'code' => $v['haoma'],
					'yid' => $yid,
					'typeid' => $game_id,
					'qi' => $k,
					'post_stuat' => 0,//先假设未发送数据
					'add_time' => $_SERVER['time'],
				);
				$this->cache_redis->lPush($key, $new_data_code);
			}
		}
	//	print_r($new_data);exit;
		if(!empty($new_data)){
			//每个彩种只保存最新100期数据做校验，完全足够使用
			$max_len = 100;
			$key_len = $this->cache_redis->lLen($key);
			if($key_len > $max_len){
				$this->cache_redis->ltrim($key, 0, $max_len - 1);
			}
			$del_lock = $post_more = 0;
			//判断是否当前有其他任务在帮忙递交未递交成功的数据，如果没有也判断是否有未递交成功数据需要一起递交
			$post_data = $new_data;
			$more_post_status = $this->cache_redis->kGet('more_post_status');
			if(empty($more_post_status) or $more_post_status <= $_SERVER['time'] - 600){
				//无递交锁或递交锁超过10分钟表示可能出现错误死锁，解锁并重新锁定，expire可能出现差错，所以还是以判断为主
				$this->cache_redis->del('more_post_status');
				$post_more = $this->cache_redis->setnx('more_post_status', $_SERVER['time']);
			}
			//print_r($post_more);exit;
			if(!empty($post_more)){
				$del_lock = 1;
				$more_data = $this->kj->index_fetch(array('post_stuat' => 0), array('id' => 1), 0, 100);
				if(!empty($more_data)){
					foreach($more_data as $k => $v){
						$post_data[] = array(
                            'typeid' => $v['typeid'],
                            'qi' => $v['qi'],
                            'add_time' => $v['add_time'],
                            'code' => $v['code'],
                            'post_stuat' => 0,
							'yid' => $v['yid'],
						);
					}
				}
			}
			//print_r($post_data);exit;
			$post_data_stuat = $this->post_data($post_data);
			//print_r($post_data_stuat);
			if($post_data_stuat == 1){
				foreach($new_data as $k => $v){
					$new_data[$k]['post_stuat'] = 1;
				}
				if(!empty($more_data)){
					foreach($more_data as $k => $v){
						$v['post_stuat'] = 1;
						$up_stuat = $this->kj->update($v['id'], $v);
					}
				}
			}else{
				$post_admin_msg = $this->post_admin_msg(2, $this->conf['api_id']);//告知总后台采集子端无法递交到采集主端
			}
			if($del_lock == 1){
				$this->cache_redis->del('more_post_status');
			}
			$add_list = $this->kj->add_list($new_data);
		}
		return 1;
	}

	//发送给总控心跳
	public function heartbeat($num = 1) {
		if($num >= 5){
			return $this->on_echo(date("Y-m-d H:i:s", $_SERVER['time']).'心跳失败');
		}
		$heartbeat_url = $this->conf['admin_heartbeat_url'];
		$post = array(
			'api_id' => $this->conf['api_id'],
			'key' => $this->conf['admin_api_key'],
		);
		$results = json_decode($this->za->curlPost($post_url, $post, 3, 5));
		if(!empty($results['stuat']) and $results['stuat'] == 1){
			//心跳成功
			$up_cache = $this->cache_redis->kSet('heartbeat', $_SERVER['time']);
			return $this->on_echo(date("Y-m-d H:i:s", $_SERVER['time']).'心跳成功');
		}else{
			$num += 1;
			return $this->heartbeat($num);
		}
	}
}

// hook common_control_after.php

?>