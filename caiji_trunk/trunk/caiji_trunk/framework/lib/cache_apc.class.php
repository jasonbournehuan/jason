<?php
// 未测试
if(!defined('FRAMEWORK_PATH')) {
	exit('FRAMEWORK_PATH not defined.');
}

class cache_apc implements cache_interface {

	public $conf;
	public function __construct($conf) {
		$this->conf = $conf;
	}

	public function __get($var) {
		
	}

	public function set($key, $value, $life = 0) {
		return apc_store($key, $value, $life);
	}

	public function get($key) {
		$data = array(); 
		if(is_array($key)) {
			foreach($key as $k) {
				$arr = apc_fetch($k);
				$arr && $data[$k] = $arr;
			}
			return $data;
		} else {
			$data = apc_fetch($key);
			return $data;
		}
		return apc_fetch($key);
	}

	public function delete($key) {
		return apc_delete($key);
	}
	
	public function flush() {
		return apc_clear_cache('user');
	}
	
	public function maxid($table, $val = FALSE) {
		$key = $table.'-Auto_increment';
		if($val === FALSE) {
			return intval($this->get($key));
		} elseif(is_string($val) && $val{0} == '+') {
			$val = intval($val);
			$val += intval($this->get($key));
			$this->set($key, $val);
			return $val;
		} else {
			 $this->set($key, $val);
			 return $val;
		}
	}
	
	public function count($table, $val = FALSE) {
		$key = $table.'-Rows';
		if($val === FALSE) {
			return intval($this->get($key));
		} elseif(is_string($val)) {
			if($val{0} == '+') {
				$val = intval($val);
				$n = intval($this->get($key)) + $val;
				$this->set($key, $n);
				return $n;
			} else {
				$val = abs(intval($val));
				$n = max(0, intval($this->get($key)) - $val);
				$this->set($key, $n);
				return $n;
			}
		} else {
			$this->set($key, $val);
			return $val;
		}
	}
	
}