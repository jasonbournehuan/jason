<?php
class cj264274 extends base_model{
	
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
            $qihao = $map['preDrawIssue'];//期号
            $data["$qihao"] = array(
                    'haoma' => $map['preDrawCode'],
                    'time' => strtotime(date($map['preDrawTime'])),
                );       
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 16,
		);
		return $datas;
	}

}
?>