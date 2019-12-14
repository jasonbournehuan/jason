<?php
/**
 * 对配置文件进行读写。
 *
 */
class mconf extends base_model {
	
	public $configs = array();
	
	function __construct() {
		parent::__construct();
	}
	
	// 保存 key值 到配置文件
	public function set_to($k, $v, $configfile = '') {
		empty($configfile) && $configfile = BBS_PATH.'conf/conf.php';	// 默认配置文件
		
		$s = trim($this->get_contents($configfile));
		// 如果没有，则追加
		if(!preg_match("#'$k'\s*=>#", $s)) {
			if(substr($v, 0, 5) != 'array') {
				$v = var_export($v, 1);
			}
			$s = preg_replace('#\);\s*\?>#', "\t'$k' => $v,\r\n);\r\n?>", $s);
		} else {
			if(substr($v, 0, 5) == 'array') {
				$s = preg_replace('#\''.$k.'\'\s*=>\s*array\([^)]+\),(\s*//[^\r\n]+[\r\n]+)?#is', "'$k' => $v,\\1", $s);
			} elseif(!is_string($v)){
				$s = preg_replace('#\''.$k.'\'\s*=>\s*\'?\d+\'?,(\s*//[^\r\n]+[\r\n]+)?#is', "'$k' => $v,\\1", $s);
			} else {
				$v = var_export($v, 1);
				$s = preg_replace('#\''.$k.'\'\s*=>\s*\'.*?\',(\s*//[^\r\n]+[\r\n]+)?#is', "'$k' => $v,\\1", $s);
			}
		}
		$this->configs[$configfile] = $s;
	}
	
	public function save($configfile = '') {
		empty($configfile) && $configfile = BBS_PATH.'conf/conf.php';
		$s = trim($this->get_contents($configfile));
		
		// 文件锁
		$lockfile = $this->conf['tmp_path'].'update_conf.lock';
		$fp = fopen($lockfile, 'wb');
		if(function_exists('flock') && !flock($fp, 3)) {
			fclose($fp);
			return FALSE;
		} else {
			// 有可能写的冲突！
			file_put_contents($configfile, $s);
			fclose($fp);
		}
		return TRUE;
	}
	
	// 避免重复存取
	private function get_contents($configfile) {
		if(!isset($this->configs[$configfile])) {
			$this->configs[$configfile] = file_get_contents($configfile);
		}
		return trim($this->configs[$configfile]);
	}
}

?>