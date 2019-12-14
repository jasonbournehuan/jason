<?php
/*
	小型数据存储，用来处理小数据保存
*/
class json_data {
	
	public $data = array();
	public $file = './json_data.js';
	
	public function __construct($file = '') {
		!empty($file) && $this->file = $file;
		!is_file($this->file) && touch($this->file);
		$this->data = core::json_decode(file_get_contents($this->file), 1);
	}
	
	public function __destruct() {
		file_put_contents($this->file, core::json_encode($this->data));
	}
	
	public static function get($key) {
		if(isset($this->data[$key])) {
			return $this->data[$key];
		}
	}
	
	public static function set($key, $val) {
		$this->data[$key] = $val;
	}
}

?>