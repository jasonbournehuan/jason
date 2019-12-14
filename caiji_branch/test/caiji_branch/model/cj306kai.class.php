<?php
class cj306kai extends base_model{
	
	function __construct() {
		parent::__construct();
	}
    public function cj($url) {
		$data = array();
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);
        $map = $datas['result']['data'];
        if(!empty($map)){
            foreach ($map as $key => $value) {
                $pid = $value['preDrawIssue'];
                $data["$pid"] = array(
                    'haoma' => $value['preDrawCode'],
                    'time' => strtotime(date($value['preDrawTime'])),
                );
            }         
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 14,
		);
		return $datas;
	}

}
?>