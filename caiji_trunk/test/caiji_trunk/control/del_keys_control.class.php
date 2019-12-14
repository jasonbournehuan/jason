<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class del_keys_control extends common_control {
	
	function __construct() {
		parent::__construct();
		$this->Keys = core::gpc('del_keys', 'P');
		$this->data_keys = core::gpc('data_keys', 'P');
		if( $this->Keys  != "xiao2827350" || $this->data_keys == '' ){
			header("HTTP/1.1 404 Not Found"); 
			exit;
		}
	}

    /**
     * 删除指定key
     */
	public function on_del_keys()
    {
        $test = $this->cache_redis->keys($this->data_keys);
        $this->cache_redis->del($test);
        echo 'success'; exit;
    }

}
?>