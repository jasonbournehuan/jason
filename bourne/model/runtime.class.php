<?php
// runtime 高速运行产生的数据，如果DB压力大，可以独立成服务，此表暂时只有一条数据。
class runtime extends base_model {
	public $data = array();		// 专门用来存储 bbs
	private $changed = FALSE;	// 专门用来存储 bbs changed
	function __construct() {
		parent::__construct();
		$this->table = 'runtime';
		$this->primarykey = array('k');
	}
	
	function __destruct() {
		if($this->changed) {
			$this->save_site();
		}
	}
	
	// threads, posts, users, todayposts, todayusers, newuid, newusername, cron_1_next_time, cron_2_next_time, toptids, cronlock
	public function read($k) {
		$arr = $this->get($k);
		return !empty($arr) ? $arr['v'] : '';
	}
	
	public function update($k, $v) {
		$v = array(
			'k'=>$k,
			'v'=>$v
		);
		return $this->set($k, $v);
	}
	
	// 合并读取，一次读取多个，增加效率
	public function &read_site() {
		$s = $this->read('site');
		$this->data = $this->unserialize_site($s);
		return $this->data;
	}
	
	public function update_site($k, $v) {
		if($v && is_string($v) && ($v[0] == '+' || $v[0] == '-')) {
			$v = intval($v);
			if($v != 0) {
				$this->data[$k] += $v;
				$this->changed = TRUE;
			}
		} else {
			$this->data[$k] = $v;
			$this->changed = TRUE;
		}
	}
	
	// 在析构函数里调用
	public function save_site() {
		$s = $this->serialize_site($this->data);
		return $this->update('site', $s);
	}
	
	// 读取 runtime key
	public function serialize_site($arr) {
		$arr['newusername'] = empty($arr['newusername']) ? '' : str_replace('|', '', $arr['newusername']);
		$s = implode("|", $arr);
		return $s;
	}
	
	// 只要 db 重新启动，读取到的 memory 表数据为空，则重新初始化 runtime
	public function unserialize_site($s) {
		if(!empty($s)) {
			$arr = explode("|", $s);
			$r = array (
				'users'=>intval($arr[0]),
				'todayapps'=>intval($arr[1]),
				'todayusers'=>intval($arr[2]),
				'cron_1_next_time'=>intval($arr[3]),
				'cron_2_next_time'=>intval($arr[4]),
				'newuid'=>intval($arr[5]),
				'newusername'=>$arr[6],
			);
		} else {
			$r = array (
				'users'=>$this->user->count(),
				'todayapps'=>0,
				'todayusers'=>0,
				'cron_1_next_time'=>0,
				'cron_2_next_time'=>0,
				'newuid'=>0,
				'newusername'=>'',
			);
		}
		return $r;
	}

	public function _delete($k) {
		return $this->delete($k);
	}
}
?>