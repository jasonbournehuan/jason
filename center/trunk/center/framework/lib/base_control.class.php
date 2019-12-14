<?php
class base_control {
	
	// 当前应用的配置
	public $conf = array();
	
	function __construct() {
		global $conf;
		$this->conf = &$conf;	// 这里需要引用，因为会把一些全局需要传递的变量放进去，比如 runtime.
		$this->shiwu = array();
	}
	
	// 仅仅寻找 model 目录
	public function __get($var) {
		if($var == 'view') {
			// 传递 全局的 $conf
			$this->view = new template($this->conf);
			return $this->view;
		} else {
			// 遍历全局的 conf，包含 model
			
			$this->$var = core::get_model($var, $this->conf);
			if(!$this->$var) {
				throw new Exception('未找到 model:'.$var);
			}
			return $this->$var;
		}
	}
	
	public function message($msg, $jumpurl = '') {
		if(core::gpc('ajax')) {
			ob_end_clean();
			$arr = array('servererror'=>'', 'status'=>1, 'message'=>$msg);
			echo core::json_encode($arr);
			
		} else {
			include FRAMEWORK_PATH.'errorpage/message.htm';
			exit;
		}
	}
	
	public function __call($method, $args) {
		throw new Exception('base_control.class.php: 未实现该方法：'.$method.': ('.var_export($args, 1).')');
	}
}
?>