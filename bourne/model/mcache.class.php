<?php
class mcache extends base_model {
	
	private $vars;// 缓存已经加载的数据
	
	function __construct() {
		parent::__construct();
	}

	public function m($models = '', $model = 'model') {
		if($model == 'model'){
			$class_name = $models;
		}else{
			$class_name = $model;
		}
		if(!empty($models)) {
			$file = BBS_PATH.'models/'.$models.'/'.$model.'.php';
			if(is_file($file)){
				include_once $file;
				$this->$class_name = new $class_name;
			}else{
				$this->$class_name = array();
			}
		}else{
			$this->$class_name = array();
		}
		return $this->$class_name;
	}

	public function read($cachename, $model = '', $arg = NULL) {
		$key = $cachename.'_'.$arg;
		if(isset($this->vars[$key])) {
			return $this->vars[$key];//避免重复加载。
		}
		$cachefile = $this->conf['cache_path'].($arg ? "{$cachename}_{$arg}_cache.php" : "{$cachename}_cache.php");
		//echo $cachefile;exit;
		if(!is_file($cachefile)) {
			$r = $this->update($cachename, $model, $arg);
			if(!$r) {
				return array();
			}
		}
		if(!is_file($cachefile)) {
			throw new Exception('cache_model:'.$cachename.' does not exists');
		} else {
			$data = include $cachefile;
			$this->vars[$key] = $data;
			return $data;
		}
	}

	public function diysave($cachename, $data = array(), $arg = NULL) {
		$cachefile = $this->conf['cache_path'].($arg ? "{$cachename}_{$arg}_cache.php" : "{$cachename}_cache.php");
		return $this->save($data, $cachefile);
	}

	public function cache_time($cachename, $arg = NULL) {
		$cachefile = $this->conf['cache_path'].($arg ? "{$cachename}_{$arg}_cache.php" : "{$cachename}_cache.php");
		if(!is_file($cachefile)) {
			$cache_time = 0;
		}else{
			$cache_time = filemtime($cachefile);
			if(intval($cache_time) < 1){
				$cache_time = 0;
			}
		}
		return $cache_time;
	}
	
	public function clear($cachename, $arg = NULL) {
		$cachefile = $this->conf['cache_path'].($arg ? "{$cachename}_{$arg}_cache.php" : "{$cachename}_cache.php");
		$key = $cachename."_".$arg;
		if(isset($this->vars[$key]))
        {
            unset($this->vars[$key]);
        }
		return is_file($cachefile) && unlink($cachefile);
	}

	public function update($cachename, $model, $arg) {
		$cachefile = $this->conf['cache_path'].($arg ? "{$cachename}_{$arg}_cache.php" : "{$cachename}_cache.php");
		$method = "get_$cachename";
		if(!empty($arg)){
			$file_name = $arg;
		}else{
			$file_name = 'cache_class';
		}
		if(method_exists($this, $method)) {
			$data = $this->$method($arg);
			if(empty($data)) {
				return array();// 强行返回，不保存到文件
			}
		}else if($model == 'models'){
			if(is_file(BBS_PATH.'models/'.$cachename.'/'.$file_name.'.php')){
				$put_cache = array();
				include BBS_PATH.'models/'.$cachename.'/'.$file_name.'.php';
				$data = $put_cache;
			}else{
				$data = array();
			}
		}else if($model == 'app'){
			if(is_file(BBS_PATH.'app/'.$cachename.'/'.$file_name.'.php')){
				$put_cache = array();
				include BBS_PATH.'app/'.$cachename.'/'.$file_name.'.php';
				$data = $put_cache;
			}else{
				$data = array();
			}
		}else{
			//throw new Exception('cache_model: '.$method.' does not exists');
			$data = array();
		}

		return $this->save($data, $cachefile);
	}
	
	private function save($var, $cachefile) {
		$s = "<?php\r\n";
		$s .= 'return '.var_export($var, TRUE).";";
		$s .= "\r\n?>";
		if(!($fp = fopen($cachefile, 'wb'))) {
			throw new Exception('cache_model: cache unwritable');
		}
		if(function_exists('flock') && !flock($fp, LOCK_EX)) {
			fclose($fp);
			return FALSE;
		}
		fwrite($fp, $s, strlen($s));
		fclose($fp);
		return $var;
	}
	
	// 获取平台数据并缓存
	private function get_platform() {
		$arr = array();
		$this->c('platform');
		$list = $this->platform->index_fetch(array(), array(), 0, 2000);
		if(!empty($list)){
			foreach($list as $v) {
				$arr[$v['id']] = $v;
			}
		}
		return $arr;
	}
	
	// 获取游戏数据并缓存
	private function get_games() {
		$arr = $arr1 = array();
		$this->c('games');
		$list = $this->games->index_fetch(array(), array(), 0, 5000);
		if(!empty($list)){
			foreach($list as $v) {
				$arr[$v['id']] = $v;
				//$arr1[$v['platform_id'].'_'.$v['game_code']] = $v;
			}
		}
		//$this->diysave('games1', $arr1);
		return $arr;
	}
	
	// 获取常见的几种 id name 格式
	private function get_miscarr() {
		$arr = array();
		return $arr;
	}
	
	// 获取接口数据并缓存
	private function get_api() {
		$api = array();
		$this->c('api');
		$apilist = $this->api->index_fetch(array(), array(), 0, 2000);
		if(!empty($apilist)){
			foreach($apilist as $v) {
				$api[$v['api_key']] = $v;
			}
		}
		return $api;
	}
}

?>