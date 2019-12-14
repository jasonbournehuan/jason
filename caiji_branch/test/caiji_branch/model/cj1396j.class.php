<?php
class cj1396j extends base_model{
	
	function __construct() {
		parent::__construct();
	}

	public function cj($url,$rule) {
		$data = array();
		$cookie = '';//该页面需要使用到的COOKIE

		$info = $this->za->curlPost($url, array(), 3, 5, $cookie, array(), '', 1);//抓取网页内容

        preg_match_all('/<table id="tableSection">(.*?)<\/table>/is', $info, $data_list);
        $data = array();
        if(!empty($data_list[1][0])) {
            preg_match_all('/<tr(.*?)<\/tr>/is', $data_list[1][0], $datas);

            switch ($rule) {
                case "rule1":
                    //匹配规则1  ahk3
                    $data = $this->match_1($datas);
                    break;
                case "rule2":
                    //匹配规则2  fc3d、xyft
                    $data = $this->match_2($datas);
                    break;
                case "rule3":
                    //匹配规则3  cqssc、fc3d、gdkl10、gd11x5、jx11x5、tjssc、xjssc、xync
                    $data = $this->match_3($datas);
                    break;
                case "rule4":
                    //匹配规则4  jsk3
                    $data = $this->match_4($datas);
                    break;
                case "rule5":
                    //匹配规则5  pk10
                    $data = $this->match_5($datas);
                    break;
            }
        }
		$reeult_datas = array(
			'data' => array_slice($data,0,50,true),
			'yid' => 3,
		);

		return $reeult_datas;
	}

	//匹配规则1  ahk3
	private function match_1($datas){
        $data = array();
        foreach($datas[1] as $k => $v){
            preg_match_all('/<td>(.*?)<\/td>/is', $v, $td_html);//取出每个表格数据做处理
            if(!empty($td_html[1][2])){
                preg_match_all('/<span><i class="num(.*?)">(.*?)<\/i>/is', $td_html[1][2], $haoma_html);//取出开奖号码数据
                if(!empty($haoma_html[2])){
                    //若号码数据不为空则表示内容合法有效，进行统一格式的数据处理
                    foreach($haoma_html[1] as $haoma_k => $haoma_v){
                        $haoma_html[1][$haoma_k] = intval($haoma_v);
                    }
                    $data[str_replace("-","",$td_html[1][0])] = array(
                        'haoma' => implode(",", $haoma_html[2]),
                        'time' => strtotime(date("Y-m-d", time()).' '.$td_html[1][1].':00'),
                    );
                }
            }
        }

        return $data;
    }

    //匹配规则2  fc3d、xyft
    private function match_2($datas){
        $data = array();//先定义空数组防止变量不存在报错
        //print_r($datas);exit;

        foreach($datas[1] as $k => $v){
            preg_match_all('/<td>(.*?)<\/td>/is', $v, $td_html);//取出每个表格数据做处理

            if(!empty($td_html[1][2])){
                preg_match_all('/datatype="(.*?)">/is', $td_html[1][2], $haoma_html);//取出开奖号码数据
                if(!empty($haoma_html[1])){
                    //若号码数据不为空则表示内容合法有效，进行统一格式的数据处理
                    foreach($haoma_html[1] as $haoma_k => $haoma_v){
                        $haoma_html[1][$haoma_k] = intval($haoma_v);
                    }
                    $qi = str_replace("-","",$td_html[1][0]);
                    if($qi < 9999){
                        $qi = date("Ymd",$_SERVER['time']-36000).sprintf("%03d", $qi);
                    }
                    $data[$qi] = array(
                        'haoma' => implode(",", $haoma_html[1]),
                        'time' => strtotime(date("Y-m-d", time()).' '.$td_html[1][1].':00'),

                    );

                }
            }
        }
        return $data;
    }

    //匹配规则3  fc3d、gdkl10、gd11x5、jx11x5、cqssc、tjssc、xjssc、xync
    private function match_3($datas){
        $data = array();//先定义空数组防止变量不存在报错
        foreach($datas[1] as $k => $v){
            preg_match_all('/<td>(.*?)<\/td>/is', $v, $td_html);//取出每个表格数据做处理
            //print_r($td_html);exit;
            if(!empty($td_html[1][2])){
                preg_match_all('/<i>(.*?)<\/i>/is', $td_html[1][2], $haoma_html);//取出开奖号码数据
                if(!empty($haoma_html[1])){
                    //若号码数据不为空则表示内容合法有效，进行统一格式的数据处理
                    foreach($haoma_html[1] as $haoma_k => $haoma_v){
                        $haoma_html[1][$haoma_k] = intval($haoma_v);
                    }
                    $qi = str_replace("-","",$td_html[1][0]);
                    if($qi < 9999){
                        $qi = date("Ymd",$_SERVER['time']-36000).sprintf("%03d", $qi);
                    }
                    $data[$qi] = array(
                        'haoma' => implode(",", $haoma_html[1]),
                        'time' => strtotime(date("Y-m-d", time()).' '.$td_html[1][1].':00'),
                    );
                }
            }
        }
        return $data;
    }

    //匹配规则4  jsk3
    private function match_4($datas){
        $data = array();//先定义空数组防止变量不存在报错
        foreach($datas[1] as $k => $v){
            preg_match_all('/<td>(.*?)<\/td>/is', $v, $td_html);//取出每个表格数据做处理
            //print_r($td_html);exit;
            if(!empty($td_html[1][2])){
                preg_match_all('/class="num(.*?)"/is', $td_html[1][2], $haoma_html);//取出开奖号码数据
                if(!empty($haoma_html[1])){
                    //若号码数据不为空则表示内容合法有效，进行统一格式的数据处理
                    foreach($haoma_html[1] as $haoma_k => $haoma_v){
                        $haoma_html[1][$haoma_k] = intval($haoma_v);
                    }
                    $qi = str_replace("-","",$td_html[1][0]);
                    if($qi < 9999){
                        $qi = date("Ymd",$_SERVER['time']-36000).sprintf("%03d", $qi);
                    }
                    $data[$qi] = array(
                        'haoma' => implode(",", $haoma_html[1]),
                        'time' => strtotime(date("Y-m-d", time()).' '.$td_html[1][1].':00'),
                    );
                }
            }
        }
        return $data;
    }

    //匹配规则5  pk10
    private function match_5($datas){
        $data = array();//先定义空数组防止变量不存在报错
        foreach($datas[1] as $k => $v){
            preg_match_all('/<td>(.*?)<\/td>/is', $v, $td_html);//取出每个表格数据做处理
            if(!empty($td_html[1][2])){
                preg_match_all('/<li><span class="num(.*?) bg"/is', $td_html[1][2], $haoma_html);//取出开奖号码数据
                //print_r($haoma_html);exit;
                if(!empty($haoma_html[1])){
                    //若号码数据不为空则表示内容合法有效，进行统一格式的数据处理
                    foreach($haoma_html[1] as $haoma_k => $haoma_v){
                        $haoma_html[1][$haoma_k] = intval($haoma_v);
                    }
                    $qi = str_replace("-","",$td_html[1][0]);
                    if($qi < 9999){
                        $qi = date("Ymd",$_SERVER['time']-36000).sprintf("%03d", $qi);
                    }
                    $data[$qi] = array(
                        'haoma' => implode(",", $haoma_html[1]),
                        'time' => strtotime(date("Y-m-d", time()).' '.$td_html[1][1].':00'),
                    );
                }
            }
        }
        return $data;
    }
}
?>