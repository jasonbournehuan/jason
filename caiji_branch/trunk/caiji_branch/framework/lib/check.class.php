<?php
class check {
	static function is_email($email) {
		return TRUE;
	}
	
	static function is_qq($qq) {
		return TRUE;
	}
	
	static function is_url($url) {
		preg_match('#http://#i', $url, $f);  //url已http://开头  i 忽略大小写
		return $f;
	}
	
}

/** 用法

Check::check_email();

*/

?>