<?php
class cj600w5 extends base_model{
	
	function __construct() {
		parent::__construct();
	}

	public function cj($url,$playGroupId) {
		$data = array();
        $post = array(
            'pageIndex' => 1,
            'pageSize' => '20',
            'openDate' => '',//开奖时间
            'number' => '',
            'playGroupId' => $playGroupId,
            'startTime' => '',
            'endTime' => '',
            'companyShortName' => '600w',
        );
        $cookie = '';//该页面需要使用到的COOKIE
        $info = $this->za->curlPost($url, $post, 3, 5, $cookie, array(), '', 1);//抓取网页内容

        $json = json_decode($info, true);
        $data = array();//先定义空数组防止变量不存在报错
        if(!empty($json['sscHistoryList'])){
            foreach($json['sscHistoryList'] as $k => $v){
                $code = explode(",", $v['openCode']);
                foreach($code as $haoma_k => $haoma_v){
                    $code[$haoma_k] = intval($haoma_v);
                }
                $new_code = implode(",", $code);
                $data[$v['number']] = array(
                    'haoma' => $new_code,
                    'time' => $v['openTime'] / 1000,
                );
            }
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 2,
		);
		return $datas;
	}
}
?>