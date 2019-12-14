<?php
class cj1395q extends base_model{
	
	function __construct() {
        parent::__construct();
    }
    public function cj($url,$type) {
        $data = array();
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $datass = json_decode($info,TRUE);
        $map = $datass['result']['data'];
        if(!empty($map)){
            if ($type=='change') {
                    $pid = '20'.$map['preDrawIssue'];
                    $qihao = substr_replace($pid,0,8,0);
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
            'yid' => 15,
        );
        return $datas;
    }
}
?>