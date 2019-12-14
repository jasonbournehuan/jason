<?php
class alisms {
	private $key;
	private $secret;
	function __construct() {
		$this->aliapi_url = 'http://dysmsapi.aliyuncs.com/';
	}
    public function push($data, $num = 1) {
		if($num > 3){
			return 3;
		}
		$common = new common;
		$content = $common->curlPost($this->aliapi_url, $data);
		$info = json_decode($content, true);
		if(!isset($info['Message'])){
			$num += 1;
			return $this->push($data, $num);
		}else if($info['Message'] == 'OK'){
			return 1;
		}else{
			return 2;
		}
	}

	public function set_key($key){
        $this->key = $key;
    }

    public function set_secret($secret){
        $this->secret = $secret;
    }

    private function encode($str){
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }
}
?>