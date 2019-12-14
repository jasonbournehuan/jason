<?php
class upload extends base_model{
	
	function __construct() {
		parent::__construct();
		$this->table = 'upload';
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
        
    //模型信息
	public function model_info(){
		$conf = array(
			'name' => '上传数据包', 
			'ico' => 'user', 
			'page' => '#', 
			'down' =>array(
				array('name'=>'上传数据', 'page' => '?models-f-m-upload-n-update.htm',),
			),
		);
		return $conf;
	}
}
?>