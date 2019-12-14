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
		//echo $cachefile;
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
	
	// 格式化以后的数据存入 cache
	private function get_forum($fid) {
	}
	
	private function get_forumarr() {
		$arr = array();
		$catelist = $this->forum->get_forum_list();
		foreach($catelist as &$cate) {
			if(!$cate['status']) {
				continue;
			}
			$arr[$cate['fid']]['name'] = $cate['name'];
			$arr2 = array();
			foreach($cate['forumlist'] as &$forum) {
				if(!$forum['status']) {
					continue;
				}
				$arr2[$forum['fid']] = $forum['name'];
				
			}
			$arr[$cate['fid']]['forumlist'] = $arr2;
		}
		return $arr;
	}
	
	// 获取单页
	private function get_duli() {
		$arr = array();
		$dulilist = $this->duli->index_fetch(array(), array(), 0, 2000);
		foreach($dulilist as $duliinfo) {
			if(!empty($duliinfo['code'])){
				$arr[$duliinfo['code']] = $duliinfo['id'];
			}else{
				$arr[$duliinfo['id']] = $duliinfo['id'];
			}
		}
		return $arr;
	}
	
	// 获取常见的几种 id name 格式
	private function get_miscarr() {
		// forum fid=>name
		$arr = array();
		
		// group groupid=>name
		/*
		$grouplist = $this->userlevel->get_userlevellist();
		foreach($grouplist as $group) {
			$arr['group'][$group['groupid']] = $group['name'];
		}
		*/
		return $arr;
	}
	
	// 取得所有管理员分组
	public function get_admingroup() {
		$levels = $level = array();
		$levels = $this->admingroup->index_fetch(array(), array(), 0, 1000);
		foreach($levels as $v){
			$level[$v['id']] = $v;
		}
		return $level;
	}
	
	// 取得所有模型
	public function get_model() {
		$models = $model = array();
		$models = $this->model->index_fetch(array(), array(), 0, 1000);
		foreach($models as $v){
			$model[$v['files']] = $v;
		}
		return $model;
	}
	
	// 获取应用接口
	private function get_app_api() {
		$arr = array();
		$apilist = $this->app->index_fetch(array(), array(), 0, 2000);
		foreach($apilist as $apiinfo) {
			$arr[$apiinfo['id']] = array(
				'api_key' => $apiinfo['api_key'],
				'stuat' => $apiinfo['paystuat'],
			);
		}
		return $arr;
	}
	
	// 取得所有會員等級
	/*
	public function get_userlevel() {
		$levels = $level = array();
		$levels = $this->userlevel->index_fetch(array(), array(), 0, 1000);
		$level[0] = array('id' => 0, 'name' => 'VIP0', 'paixu' => 0);
		foreach($levels as $v){
			$level[$v['id']] = $v;
		}
		return $level;
	}
	*/
	
	// 取得所有快速登录信息
	public function get_logininfo() {
		$logins = $login = array();
		$logins = $this->connettype->index_fetch(array('stuat' => 1,), array('paixu' => 2), 0, 1000);
		foreach($logins as $v){
			$login[$v['id']] = $v;
		}
		return $login;
	}
	
	// 取得所有API信息
	public function get_api() {
		$apis = $api = array();
		$apis = $this->api->index_fetch(array('stuat' => 1,), array(), 0, 1000);
		foreach($apis as $v){
			$api[$v['apikey']] = $v;
		}
		return $api;
	}
	
	// 取得所有模塊接口信息
	public function get_modelapi() {
		$modelapis = $modelapi = array();
		$modelapis = $this->modelapi->index_fetch(array(), array('paixu' => 2), 0, 1000);
		foreach($modelapis as $v){
			$modelapi[$v['id']] = $v;
		}
		return $modelapi;
	}
}

?>