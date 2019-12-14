<?php
class api_log extends base_model{
	
	function __construct() {
		parent::__construct();
		$this->table = 'api_log';
		$this->primarykey = array('id');
		$this->maxcol = 'id';
	}
	
	public function create($arr) {
		empty($arr['id']) && $arr['id'] = $this->maxid('+1');
		if($this->set($arr['id'], $arr)) {
			$this->count('+1');
			return $arr['id'];
		} else {
			$this->maxid('-1');
			return 0;
		}
	}
	
	public function update($uid, $arr) {
		return $this->set($uid, $arr);
	}
	
	public function read($uid) {
		return $this->get($uid);
	}

	public function _delete($uid) {
		$return = $this->delete($uid);
		if($return) {
			$this->count('-1');
		}
		return $return;
	}

	public function update_array($id, $arr) {
		return $this->update1($id, $arr);
	}
}
?>