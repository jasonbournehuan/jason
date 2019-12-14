<?php
class cj360 extends base_model{
	
	function __construct() {
		parent::__construct();
	}
    public function cj($url) {
		$data = array();
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);
        if(!empty($datas['list'])){
            foreach($datas['list'] as $k => $v){
                //循环每个数据块再用正则取出对应数据组成统一的数据格式
                $number1 = str_replace("+"," ",$v['WinNumber']);
                $number2 = explode(" ",$number1);
                $data[$v['Issue']] = array(
                    'haoma' => implode(",", $number2),
                    'time' => strtotime($v['EndTime']),
                );
            }
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 1,
		);
		return $datas;
	}
}
?>