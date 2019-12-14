<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'control/common_control.class.php';

class api_control extends common_control {
	
	function __construct() {
		parent::__construct();
		//外部猜解KEY的概率太低，所以选择不用多重加密的方式直接校验
		$key = core::gpc('key', 'P');
		if($key != $this->conf['admin_api_key']){
			header("HTTP/1.1 404 Not Found"); 
			exit;
		}
	}

	//处理更新压缩包
	public function on_update($num = 1){
		if($num > 3){
			$error = array('stuat' => 2, 'msg' => '获取压缩包失败');
		}
		//版本号不可能大于1以上的更新，禁止大于1的版本号更新防止猜解
		$url = core::gpc('url', 'P');
		$version = core::gpc('version', 'P');
		if($version > $this->conf['api_version'] and $version < $this->conf['api_version'] + 1 and !empty($url)){
			$file = BBS_PATH.'cache/update.zip';
			$snoopy = new Snoopy;
			$snoopy->fetch($url);
			$file_info = $snoopy->results;
			if($snoopy->status >= 200 and $snoopy->status < 300){
				file_put_contents($file, $file_info);
				if(file_exists($file)){
					$this->za->unzip($file);
					$conffile = BBS_PATH.'conf/conf.php';
					if(!is_file($conffile)) {
						$error = array('stuat' => 2, 'msg' => '配置文件文件不存在！');
					}
					if(!is_writable($conffile)) {
						$error = array('stuat' => 2, 'msg' => '配置文件文件不可写！');
					}
					if(empty($error)){
						$this->mconf->set_to('api_version', $version, $conffile);
						$this->mconf->save();
						$error = array('stuat' => 1, 'msg' => '更新成功！');
					}
				}else{
					$num += 1;
					return $this->on_update($num);
				}
			}else{
				$error = array('stuat' => 2, 'msg' => '更新文件不存在！');
			}
		}else{
			header("HTTP/1.1 404 Not Found"); 
			exit;
		}
		echo json_encode($error);exit;
	}

	//处理更新api_key
	public function on_update_api_key(){
		//版本号不可能大于1以上的更新，禁止大于1的版本号更新防止猜解
		$new_key = core::gpc('new_key', 'P');
		$url = core::gpc('url', 'P');
		if(!empty($new_key)){
			$conffile = BBS_PATH.'conf/conf.php';
			if(!is_file($conffile)) {
				$error = array('stuat' => 2, 'msg' => '配置文件文件不存在！');
			}
			if(!is_writable($conffile)) {
				$error = array('stuat' => 2, 'msg' => '配置文件文件不可写！');
			}
			if(empty($error)){
				$this->mconf->set_to('api_key', $new_key, $conffile);
				$this->mconf->set_to('api_url', $url, $conffile);
				$this->mconf->save();
				$error = array('stuat' => 1, 'msg' => '更新成功！');
			}
		}else{
			header("HTTP/1.1 404 Not Found"); 
			exit;
		}
		echo json_encode($error);exit;
	}

	//处理更新admin_api_key
	public function on_update_admin_api_key(){
		//版本号不可能大于1以上的更新，禁止大于1的版本号更新防止猜解
		$new_key = core::gpc('new_key', 'P');
		$url = core::gpc('url', 'P');
		if(!empty($new_key)){
			$conffile = BBS_PATH.'conf/conf.php';
			if(!is_file($conffile)) {
				$error = array('stuat' => 2, 'msg' => '配置文件文件不存在！');
			}
			if(!is_writable($conffile)) {
				$error = array('stuat' => 2, 'msg' => '配置文件文件不可写！');
			}
			if(empty($error)){
				$this->mconf->set_to('admin_api_key', $new_key, $conffile);
				$this->mconf->set_to('admin_api_url', $url, $conffile);
				$this->mconf->save();
				$error = array('stuat' => 1, 'msg' => '更新成功！');
			}
		}else{
			header("HTTP/1.1 404 Not Found"); 
			exit;
		}
		echo json_encode($error);exit;
	}

	//获得版本信息
	public function on_get_version(){
		$error = array('stuat' => 1, 'msg' => '', 'version' => $this->conf['api_version']);
		echo json_encode($error);exit;
	}
}
?>