<?php
class cjtw1680380 extends base_model{
	
	function __construct() {
		parent::__construct();
	}
    public function cj($url,$type) {
		$data = array();
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, '', array(), '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);//preDrawIssue期号 preDrawTime 时间 preDrawCode中奖号
        $map = $datas['result']['data'];
        if(!empty($map)){
             if ($type==1) {
                    $qihao = '20'.$map['preDrawIssue'];
                }else{
                    $qihao = $map['preDrawIssue'];
                }
             $data["$qihao"] = array(
                    'haoma' => $map['preDrawCode'],
                    'time' => strtotime(date($map['preDrawTime'])),
                );  
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 12,
		);
		return $datas;
	}
}
?>