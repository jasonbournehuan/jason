<?php
class cjopencai extends base_model{
	
	function __construct() {
		parent::__construct();
	}

    public function cj($url) {
		$data = array();
        $info = $this->za->curlPost($url, array(), 3, 5, array(), array(), '', 1);//抓取网页内容
        $json = json_decode($info, true);
        //print_r($json);exit;
        $data = array();//先定义空数组防止变量不存在报错
        if(!empty($json['data'])){
            foreach($json['data'] as $k => $v){
                $code = explode(",", $v['opencode']);
                foreach($code as $haoma_k => $haoma_v){
                    $code[$haoma_k] = intval($haoma_v);
                }
                $new_code = implode(",", $code);
                $data[$v['expect']] = array(
                    'haoma' => $new_code,
                    'time' => $v['opentimestamp'],
                );
            }
        }
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 5,
		);
		return $datas;
	}
}
?>