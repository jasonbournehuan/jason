<?php
class cjcaim8 extends base_model{
	
	function __construct() {
		parent::__construct();
	}
    public function cj($url,$num) {
		$data = array();
        $cookie = '';//该页面需要使用到的COOKIE
        $header = array(         
            "accept: */*",
            "accept-encoding: gzip, deflate, br",
            "content-length: 0",
            "origin: https://www.caim8.com",
            "referer: https://www.caim8.com/syxwsh/index.html",
            "sec-fetch-mode: cors",
            "sec-fetch-site: same-origin",
            "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36",
            "x-requested-with: XMLHttpRequest"

        );
        $data = $datas = array();
        $info = $this->za->curlPost($url, array(), 3, 5, $cookie, $header, '', 1);//抓取网页内容
        $datas = json_decode($info,TRUE);
        $map = $datas['data'][$num];
        if(!empty($map)){
            if ($num==36) {
                $qihao = $map['open_last_qihao'];
                $data[$qihao] =  array(
                    'haoma' => $map['open_last_data'],
                    'time' => strtotime('now'),
                );

            }else if($num==10){
                    foreach($map['open_list'] as $k => $v){
                    $hao = str_replace("_",",",$v['data']);//处理号码
                    $pid = substr_replace($v['qihao'],'',8,1);//去掉
                    $data["$pid"] = array(
                        'haoma' => $hao,
                        'time' => $v['time'],
                    );
                }
            }else{
                foreach($map['open_list'] as $k => $v){
                    $hao = str_replace("_",",",$v['data']);//处理号码
                    $pid = $v['qihao'];//期号
                    $data["$pid"] = array(
                        'haoma' => $hao,
                        'time' => $v['time'],
                    );
                }
            }               
        }
        $datas = array(
            'data' => array_slice($data,0,50,true),
            'yid' => 17,
        );
        return $datas;
        
	}
}
?>