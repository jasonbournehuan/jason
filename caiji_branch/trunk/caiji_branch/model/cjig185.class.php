<?php
class cjig185 extends base_model{
	
	function __construct() {
		parent::__construct();
	}

	public function cj($url) {

		$data = array();
        $cookie = '';
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);
         //print_r($datas['result']);
        if(!empty($datas['result'])){
            foreach($datas['result'] as $k => $v){
                //循环每个数据块再用正则取出对应数据组成统一的数据格式
                $data[$v['preDrawIssue']] = array(
                    'haoma' => implode(",", $v['preDrawCode']),
                    'time' => $v['preDrawTime']/1000,
                );
            }
        }
        //print_r($data); //打印格式化后的数据
		$datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 4,
		);
		return $datas;
	}
}
?>