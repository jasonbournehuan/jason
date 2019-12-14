<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
class common_control extends base_control {
	// 为了避免与 model 冲突，加下划线分开
	public $_sid = '';		// session id
	public $_user = array();	// 全局 user
	public $_admin = array();	// 全局 admin
	public $_dev = array();	// 全局 dev
	
	// 计划任务
	protected $_cron_1_run = 0;	// 计划任务1 是否被激活, 15 分钟执行一次
	protected $_cron_2_run = 0;	// 计划任务2 是否被激活, 每天0点执行一次
	
	// hook common_control_before.php
	
	// 初始化
	function __construct() {
		// hook common_control_construct_before.php
		parent::__construct();
		// hook common_control_construct_after.php
		$this->init_timezone();
		//$this->conf['runtime'] = &$this->runtime->read_site();// 析构函数会比 mysql 的析构函数早。所以不用担心mysql被释放。
		// hook common_control_init_after.php
	}
	
	private function init_timezone() {
		//print_r($this->cache_redis->lRange('cron_1', 0, -1));exit;
		//$this->cache_redis->del('more_post_stuat');exit;
		//print_r($this->cache_redis->kGet('more_post_stuat'));exit;
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
		$appurl = $this->conf['app_url'];
		preg_match('#^http://([^/]+)/#', $appurl, $m);
		$installhost = $m[1];
		$installhosts = "api.".$m[1];
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
	
	//发送错误到总后台
	protected function post_admin_msg($error_info = array(), $num = 1) {
		$lock_post_admin_status_name = 'lock_post_admin';
		if($num > 5){
			//采集主端多次递交总控制端出错也需要保存一次记录
			$error_log_data = array(
				'typeid' => 0,
				'qi' => 0,
				'add_time' => $_SERVER['time'],
				'status' => 2,
				'infos' => '',
				'error_typeid' => 6,
			);
			$add_error_log = $this->errorlog->create($error_log_data);
			$del_game_push_cache = $this->cache_redis->del($lock_post_admin_status_name);
			return 2;
		}
		$post_url = $this->conf['admin_api_url'];
		$snoopy = new Snoopy;
		$post = array(
			'key' => $this->conf['admin_api_key'],
			'error_info' => array(),
		);
		if(empty($error_info)){
			$lock_post_admin_status = $this->cache_redis->kGet($lock_post_admin_status_name);
			if(!empty($lock_post_admin_status) and $lock_post_admin_status <= $_SERVER['time'] - 20){
				//20秒前的属于死锁，解锁可以重新发送
				$del_lock = $this->cache_redis->del($lock_post_admin_status_name);
			}
			$lock_post_admin_status = $this->cache_redis->setnx($lock_post_admin_status_name, $_SERVER['time']);
			if(!empty($lock_post_admin_status)){
				//锁定当前任务执行递交错误数据到总控端，先检测是否
				$push_logs = $this->errorlog->index_fetch(array('status' => array('<>' => 1)), array('add_time' => 1), 0, 100);
				if(!empty($push_logs)){
					foreach($push_logs as $k => $v){
						$error_info[] = $v;
					}
					$post['error_info'] = json_encode($error_info);
				}
			}
		}else{
			$post['error_info'] = json_encode($error_info);
		}
		if(!empty($post['error_info'])){
			$snoopy->submit($post_url, $post);
			$results = json_decode($snoopy->results, true);
			if(!empty($results['stuat']) and $results['stuat'] == 1){
				foreach($error_info as $k => $v){
					$v['status'] = 1;
					$up_error_log = $this->errorlog->update($v['id'], $v);
				}
				$del_game_push_cache = $this->cache_redis->del($lock_post_admin_status_name);
				return 1;
			}else{
				$num += 1;
				return $this->post_admin_msg($error_info, $num);
			}
		}
	}

	//发送给总控心跳
	public function heartbeat($num = 1) {
		if($num >= 5){
			return $this->on_echo(date("Y-m-d H:i:s", $_SERVER['time']).'心跳失败');
		}
		$heartbeat_url = $this->conf['admin_heartbeat_url'];
		$snoopy = new Snoopy;
		$post = array(
			'api_id' => 0,//0表示采集主端，1-10表示采集子端
			'key' => $this->conf['admin_api_key'],
		);
		$snoopy->submit($heartbeat_url, $post);
		$results = json_decode($snoopy->results, true);
		if(!empty($results['stuat']) and $results['stuat'] == 1){
			//心跳成功
			$up_cache = $this->cache_redis->kSet('heartbeat', $_SERVER['time']);
			return $this->on_echo(date("Y-m-d H:i:s", $_SERVER['time']).'心跳成功');
		}else{
			$num += 1;
			return $this->heartbeat($num);
		}
	}

	public function on_echo($info) {
		echo iconv("UTF-8", "GB2312//IGNORE", $info);
		//echo $info;
	}

	//判断开奖获取所有缓存数据，如果最多只有一条从数据库中读取
	public function get_open_cache($cache_name) {
		$cache_data = $this->cache_redis->lRange($cache_name, 0, -1);
		if(count($cache_data) <= 1){
			$exp_cache_name = explode("-", $cache_name);
			$db_data = $this->kj->index_fetch(array('typeid' => $exp_cache_name[0], 'qi' => $exp_cache_name[1]), array('add_time' => 1), 0, 100);
			if(!empty($db_data) and count($db_data) > count($cache_data)){
				$cache_data = array();
				$this->cache_redis->del($cache_name);
				foreach($db_data as $k => $v){
					$new_cache = $v['sid'].'-'.$v['yid'].'-'.$v['code'];
					$cache_data[] = $new_cache;
					$push_cache = $this->cache_redis->lPush($cache_name, $new_cache);
				}
			}
		}
		return $cache_data;
	}
}
// hook common_control_after.php
?>