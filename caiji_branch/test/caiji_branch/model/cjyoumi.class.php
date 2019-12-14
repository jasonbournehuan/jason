<?php
class cjyoumi extends base_model{
	
	function __construct() {
		parent::__construct();
	}
    public function cj($url,$type) {
		$data = array();
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);
        if(!empty($datas['list'])){
            foreach ($datas['list'] as $key => $value) {
                if ($type=='change') {
                    $pid = substr_replace($value['period'],0,8,0);
                }else{
                    $pid = $value['period'];
                }   
                $data["$pid"] = array(
                    'haoma' => $value['result'],
                    'time' => strtotime(date($value['date'])),
                );
            }         
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 11,
		);
		return $datas;
	}

}
?>