<?php
class model extends base_model{
	
	function __construct() {
		parent::__construct();
		$this->table = 'model';
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

	public function config($id) {
		$config = array();
		if(!empty($this->conf['cache_colse'])){
			$mem = new cache_memcache($this->config['cache']['memcache']);
			$cache = $mem->get("model_config_".$id);
			if(!empty($cache)){
				return $cache;
			}
		}
		$info = $this->get($id);
		if(!empty($info)){
			$info['config'] = json_decode(stripslashes($info['config']), true);
			foreach($info['config'] as $k => $v){
				$config[$k] = $v['field_info'];
			}
		}
		if(!empty($this->conf['cache_colse'])){
			$mem = new cache_memcache($this->config['cache']['memcache']);
			$mem->set("model_config_".$id, $config, 0, 86400);
		}
		return $config;
	}
	
	public function update_config($id) {
		if(!empty($this->conf['cache_colse'])){
			$mem = new cache_memcache($this->config['cache']['memcache']);
			$mem->delete("model_config_".$id);
		}
	}
        
    //模型信息
	public function model_info(){
		$conf = array(
			'name' => '模型管理', 
			'ico' => 'delicious', 
			'page' => '#', 
			'down' =>array(
				array('name'=>'模块列表', 'page' => '?models-f-m-model-n-list.htm',),
				array('name'=>'增加模块', 'page' => '?models-f-m-model-n-add.htm',),
			),
		);
		return $conf;
	}
}
?>