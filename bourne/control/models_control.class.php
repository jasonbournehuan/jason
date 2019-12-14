<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class models_control extends common_control {
	
	function __construct() {
		parent::__construct();
		$m = core::gpc('m', 'R');
		$class_file = BBS_PATH.'models/'.$m.'/class.php';
		if(is_file($class_file)){
			include $class_file;
		}
	}
	
	function on_f() {
		$m = core::gpc('m', 'R');
		$this->conf['view_path'] = array(BBS_PATH.'models/'.$m.'/view/');
		$n = core::gpc('n', 'R');
		if(empty($n)){
			$uri = $this->za->url_uri();
			foreach($uri as $k => $v){
				$$k = $v;
			}
		}
		$function_file = BBS_PATH.'models/'.$m.'/'.$n.'.php';
		if(is_file($function_file)){
			include $function_file;
		}else{
			header("HTTP/1.1 404 Not Found");  
			header("Status: 404 Not Found");  
			exit;
		}
	}
}
?>