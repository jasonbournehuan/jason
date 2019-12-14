<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

class common_control extends base_control {
	
	// 为了避免与 model 冲突，加下划线分开
	public $_sid = '';		// session id
	public $_user = array();	// 全局 user
	public $_class_list = array();	// 全局 class_list
	public $_admin = array();	// 全局 admin
	public $_dev = array();	// 全局 dev
	public $admin_system = array();	// 全局 admin_system
	
	// header 相关
	public $_title = array();	// header.htm title
	public $_nav = array();		// header.htm 导航
	public $_seo_keywords = '';	// header.htm keywords
	public $_seo_description = '';	// header.htm description
	public $_checked = array();	// 选中状态
	
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
		//$this->conf['runtime'] = &$this->runtime->read_site();	// 析构函数会比 mysql 的析构函数早。所以不用担心mysql被释放。

		//$this->check_lang();
		//$this->init_view();
		//$this->init_sid();
		//$this->init_user();
		//$this->check_ip();
		//$this->check_safecode();
		//$this->check_domain();
		//$this->init_cron();
		//$this->check_msg();
		// hook common_control_init_after.php
	}
	
	private function init_timezone() {
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
	
	private function init_view() {
		$this->view->assign('conf', $this->conf);
		$this->view->assign('_title', $this->_title);
		$this->view->assign('_nav', $this->_nav);
		$this->view->assign('_checked', $this->_checked);
		$this->view->assign('cron_1_run', $this->_cron_1_run);
		if(defined('FORM_HASH') == false){
			define('FORM_HASH', misc::form_hash($this->conf['public_key']));
		}
		// hook common_control_init_view_after.php
	}
	
	// 初始化 sid
	private function init_sid() {
		$key = $this->conf['cookiepre'].'sid';
		$sid = core::gpc($key, 'R');
		if(!$sid) {
			$sid = substr(md5($_SERVER['REMOTE_ADDR'].rand(1, 2147483647)), 0, 16); // 兼容32,64位
			misc::set_cookie($key, $sid, $_SERVER['time'] + 86400 * 30, '/');
		}
		$this->_sid = $sid;
		$this->view->assign('_sid', $this->_sid);
		
		// hook common_control_init_sid_after.php
	}
	
	private function ip() {
		$ip['ip'] = $this->za->get_ip();
		$ip['data'] = array();
		if($ip['ip'] != 'unknown'){
			$data = $this->ip->find($ip['ip'], 'CN');
			$ip['data']['guo'] = $data[0];
			$ip['data']['sheng'] = $data[1];
			$ip['data']['shi'] = $data[2];
		}
		return $ip;
	}
	
	// 初始化 _user, 解密 cookie
	private function init_user() {
		$auth = core::gpc($this->conf['cookiepre'].'auth', 'R');
		$this->view->assign('_auth', $auth);
		$this->m('user');
		$this->_user = $this->user->decrypt_auth($auth);
		if($this->_user['id'] !=0){
			$session_out_time = 300;
			session_set_cookie_params($session_out_time);
			ob_start();
			session_start();
			$this->_userdbinfo = $this->user->read($this->_user['id']);
			if(empty($this->_userdbinfo) or $this->_userdbinfo['login_time'] != $this->_user['login_time'] or $this->_userdbinfo['login_ip'] != $this->_user['ip'] or $this->_userdbinfo['end_session'] != session_id()){
				$error = array();
				$_SESSION['id'] = 0;
				session_destroy();
				misc::set_cookie($this->conf['cookiepre'].'auth', '', 0, '/');
				header("Location: ".$this->conf['app_url']);
				exit;
			}else{
				//unset($this->_user['password']);
				if(!empty($this->_userdbinfo)){
					$this->_user = $this->_user + $this->_userdbinfo;
				}
				if(!empty($this->_userdbinfo) and $this->_userdbinfo['stuat'] == 2){
					$error = array();
					$_SESSION['id'] = 0;
					session_destroy();
					misc::set_cookie($this->conf['cookiepre'].'auth', '', 0, '/');
					header("Location: ".$this->conf['app_url']);
					exit;
				}else{
					$_SESSION['id'] = $this->_user['id'];
					$_SESSION['username'] = $this->_user['username'];
					$_SESSION['end_time'] = $_SERVER['time'];
				}
			}
		}
		$_SERVER['miscarr'] = $this->mcache->read('miscarr');
		$this->view->assign('_user', $this->_user);
		//print_r($this->_user);
		//exit;
		// hook common_control_init_user_after.php
	}
	
	// 开始事务模式
	public function shiwu_start(){
		if(empty($this->conf['shiwu'])){
			throw new Exception('未开启事务模式！');
		}else if($this->conf['shiwu'] == 2){
			//$shiwu_sql1 = "start transaction";
			//$query_sql1 = $this->za->mysqlquery( $shiwu_sql1 );
			$shiwu_sql3 = "BEGIN";
			$query_sql3 = $this->za->mysqlquery( $shiwu_sql3 );
			$shiwu_sql2 = "SET AUTOCOMMIT=0";
			$query_sql2 = $this->za->mysqlquery( $shiwu_sql2 );
		}
	}
	
	// 事务保存
	public function shiwu_ok(){
		if(empty($this->conf['shiwu'])){
			throw new Exception('未开启事务模式！');
		}else if($this->conf['shiwu'] == 2){
			$shiwu_sql2 = "COMMIT";
			$query_sql2 = $this->za->mysqlquery( $shiwu_sql2 );
			$shiwu_sql1 = "SET AUTOCOMMIT=1";
			$query_sql1 = $this->za->mysqlquery( $shiwu_sql1 );
		}
	}
	
	// 事务退回
	public function shiwu_back(){
		if(empty($this->conf['shiwu'])){
			throw new Exception('未开启事务模式！');
		}else if($this->conf['shiwu'] == 2){
			$shiwu_sql2 = "ROLLBACK";
			$query_sql2 = $this->za->mysqlquery( $shiwu_sql2 );
			$shiwu_sql1 = "SET AUTOCOMMIT=1";
			$query_sql1 = $this->za->mysqlquery( $shiwu_sql1 );
		}else{
			//$db = $this->moneylog->get(2);
			//echo "888";print_r($db);
			print_r($this->_class_list);
		}
	}
	
	// 检查IP
	private function check_ip() {
		// IP 规则
		if($this->conf['iptable_on']) {
			$arr = include BBS_PATH.'conf/iptable.php';
			$blacklist = $arr['blacklist'];
			$whitelist = $arr['whitelist'];
			$ip = $_SERVER['REMOTE_ADDR'];
			if(!empty($blacklist)) {
				foreach($blacklist as $black) {
					if(substr($ip, 0, strlen($black)) == $black) {
						$this->message('对不起，您的IP ['.$ip.'] 已经被禁止，如果有疑问，请联系管理员。', 0);
					}
				}
			}
			if(!empty($whitelist)) {
				$ipaccess = FALSE;
				foreach($whitelist as $white) {
					if(substr($ip, 0, strlen($white)) == $white) {
						$ipaccess = TRUE;
						break;
					}
				}
				if(!$ipaccess) {
					$this->message('对不起，您的IP ['.$ip.'] 不允许访问，如果有疑问，请联系管理员。', 0);
				}
			}
		}
		
		// hook common_control_check_ip_after.php
	}
	
	// 检查域名，如果不在安装域名下，跳转到安装域名。
	private function check_domain() {
		$host = core::gpc('HTTP_HOST', 'S');
		if($host != $m[1] and $host != $installhosts) {
			$currurl = misc::get_script_uri();
			$newurl = preg_replace('#^http://([^/]+)/#', "http://$installhost/", $currurl);
			header("Location: $newurl");
			exit;
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
		$this->message('提交成功！', TRUE, '?index-123.htm');
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
			$this->conf['view_path'] = array(BBS_PATH.'framework/errorpage/');
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
	
	// upload 相关，可能会给人偶然扫描到。todo: 安全性
	protected function get_aid_from_tmp($uid) {
		$file = $this->conf['tmp_path'].$uid.'_aids.tmp';
		if(!is_file($file)) {
			return array();
		}
		$aids = trim(file_get_contents($file));
		return explode(' ', $aids);
	}
	
	// upload 相关
	protected function clear_aid_from_tmp($uid) {
		$file = $this->conf['tmp_path'].$uid.'_aids.tmp';
		is_file($file) && unlink($file);
	}
	
	public function c($class = '') {
		if(!empty($class)) {
			$file = BBS_PATH.'class/'.$class.'.class.php';
			if(is_file($file)) {
				include_once $file;
				if(!empty($this->conf['shiwu']) and empty($this->_class_list[$class])){
					$this->_class_list[$class] = $_SERVER['time'];
				}
				$this->$class = new $class();
			}else{
				$this->$class = array();
			}
		}else{
			$this->$class = array();
		}
	}
	
	public function m($models = '', $model = 'model') {
		if($model == 'model'){
			$class_name = $models;
		}else{
			$class_name = $model;
		}
		if(!empty($this->conf['shiwu']) and empty($this->_class_list[$class_name])){
			$this->_class_list[$class_name] = $_SERVER['time'];
		}
		$this->$class_name = $this->mcache->m($models, $model);
	}
	
	public function check_user($user_data) {
		$this->c('user');
		$user_list = $this->user->index_fetch(array('uid' => $user_data['uid'], 'site_id' => $user_data['site_id']), array('id' => 2), 0, 1);

		if(count($user_list) < 1){
			//用户不存在，则入库用户数据
			$this->c('id_to_code');
			$en_username = $this->id_to_code->en_username($user_data['site_id'], $user_data['uid'], 5, 16);
			$user_data['password'] = substr(md5($user_data['site_id'].$en_username.$user_data['old_username']), 8, 16);
			$user_data['username'] = $en_username;
			$user_data['add_time'] = $user_data['end_time'] = $_SERVER['time'];
			$user_data['id'] = $this->user->add($user_data);
		}else{
			$ip = $user_data['ip'];
			list($userk, $user_data) = each($user_list);
			$user_data['ip'] = $ip;
		}
		return $user_data;
	}
	/*
	
	//用户锁，防止用户多次读取修改导致金额错误使用
	public function lock_user($uid){
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else{
			$file = $this->conf['lock_type'].'user-'.$uid.'.txt';
			if(file_exists($file)){
				sleep(0.5);
				return $this->lock_user($uid);
			}else{
				file_put_contents($file, $_SERVER['time']);
				return 1;
			}
		}
	}
	
	//用户锁，防止用户多次读取修改导致数据错误使用，不一定保证绝对唯一，但是防止一部分情况的重复，要害更新最好使用update检测
	public function lock_user($uid){
		//防止意外死锁，执行时间只给30秒，超时前也够用了
		set_time_limit(30);
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else if($this->conf['lock_type'] == 2){
			//MYSQL内存表锁
			$this->m("user", "lock");
			$handle_type = 1;//重复请求的三种处理方式，1=只处理第一条其他抛弃，2=全部处理，3=全部抛弃
			$lock_stuat = $this->lock->total(array('uid' => $uid));
			if($lock_stuat == 0 or $handle_type == 2){
				$lock_data = array(
					'uid' => $uid,
					'add_time' => time(),
				);
				$lock_id = $this->lock->create($lock_data);
				if($lock_id >= 1){
					//延迟0.3秒防止入库中的数据没有被查询到
					usleep(300000);
					$lock_top_id = $this->get_lock_user($uid);
					echo $lock_id."|||".$lock_top_id."|||";
					if($handle_type == 1){
						if($lock_top_id == $lock_id){
							echo $lock_top_id."||";
							return 1;
						}else{
							$this->lock->_delete($lock_id);
							return 2;//不需处理数据，抛弃
						}
					}else if($handle_type == 2){
						return 1;
					}else{
						$this->lock->_delete($lock_id);
						return 2;//全部不处理数据，抛弃
					}
				}else{
					usleep(rand(300000, 1000000));
					return $this->lock_user($uid);
				}
			}else if($handle_type == 1){
				//只处理第一条，其他抛弃
				return -1;//抛弃处理
			}else if($handle_type == 3){
				return -1;//全部抛弃
			}else{
				sleep(rand(300000, 1000000));
				return $this->lock_user($uid);
			}
		}else{
			$file = $this->conf['lock_path'].'user-'.$uid.'.txt';
			if(file_exists($file)){
				//使用随机间隔防止冲突
				sleep(rand(500000, 2000000));
				return $this->lock_user($uid);
			}else{
				//使用追加方式追加，这样判断文件大小也可以知道同时的请求有多少
				file_put_contents($file, "1", FILE_APPEND);
				return $this->get_lock_user($uid);
			}
		}
	}

	//获得用户锁的同时处理事务数，不包括等待中的事务请求
	public function get_lock_user($uid){
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else if($this->conf['lock_type'] == 2){
			//MYSQL内存表锁
			$this->m("user", "lock");
			$lock_list = $this->lock->index_fetch(array('uid' => $uid), array('id' => 1), 0, 1);
			list($k, $v) = each($lock_list);
			return $v['id'];
		}else{
			//文件锁
			$file = $this->conf['lock_path'].'user-'.$uid.'.txt';
			if(file_exists($file)){
				return filesize($file);
			}else{
				return 0;
			}
		}
	}

	//解锁用户锁
	public function unlock_user($uid){
		set_time_limit(0);
		if($this->conf['lock_type'] == 1){
			//暂时不考虑使用memcache锁
		}else if($this->conf['lock_type'] == 2){
			//MYSQL内存表锁
			$this->m("user", "lock");
			$lock_list = $this->lock->index_fetch(array('uid' => $uid), array('id' => 1), 0, 1000);
			if(count($lock_list) >= 1){
				foreach($lock_list as $k => $v){
					$this->lock->_delete($v['id']);
				}
			}
			return 1;
		}else{
			//文件锁
			$file = $this->conf['lock_path'].'user-'.$uid.'.txt';
			if(file_exists($file)){
				//删除锁文件
				unlink($file);
				return 1;
			}else{
				//没有锁存在
				return 2;
			}
		}
	}
	*/

	//计算指定时间内的数据
	public function total_day_data($start_date = '', $end_date = ''){
		$this->c('daylog');
		$data = $this->daylog->total_day_data($start_date, $end_date);
		return $data;
	}

	//更新彩票缓存
	public function caipiao_list_cache($gameid){
		$lock_cache = $this->lock->lock('game'.$gameid.'_list_cache', $gameid);
		if($lock_cache == 1){
			$this->mcache->clear('game'.$gameid.'_list_cache');
			$data = array();
			$this->m('game', 'caipiaolog');
			$info_list = $this->caipiaolog->index_fetch(array('gid' => $gameid, 'feng_time' => array('<=' => $_SERVER['time'])), array('feng_time' => 2), 0, 5);
			if(!empty($info_list)){
				foreach($info_list as $k => $v){
					$data['jiu'][] = array(
						'id' => $v['id'],
						'qihao' => $v['qihao'],
						'open_time' => $v['open_time'],
						'feng_time' => $v['feng_time'],
						'up_time' => $v['up_time'],
						'code' => $v['code'],
					);
				}
			}
			$info_list = $this->caipiaolog->index_fetch(array('gid' => $gameid, 'up_time' => 0, 'feng_time' => array('>' => $_SERVER['time'])), array('feng_time' => 1), 0, 1);
			if(!empty($info_list)){
				foreach($info_list as $k => $v){
					$data['xin'][] = array(
						'id' => $v['id'],
						'qihao' => $v['qihao'],
						'open_time' => $v['open_time'],
						'feng_time' => $v['feng_time'],
						'up_time' => $v['up_time'],
						'code' => $v['code'],
					);
					$data['end_time'] = $v['feng_time'];
				}
			}
			$this->mcache->diysave('game'.$gameid.'_list_cache', $data);
			$unlock_game = $this->lock->unlock('game'.$gameid.'_list_cache', $gameid);
		}
	}
}

// hook common_control_after.php

?>