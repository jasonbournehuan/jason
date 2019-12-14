<?php
	$typeid = 10010;//彩种ID
	$cron_name = '福彩3D';
    //每天 21:15开奖
    $int_time = intval(date("Hi", $_SERVER['time']));
    if($int_time < 2115){
        $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
        exit;
    }
	$url ="https://m.600w5.com:88/apis/ssc/getDataHistory.json";//要抓取数据的页面地址
    $playGroupId = 5;
    $datas = $this->cj600w5->cj($url,$playGroupId);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID   2
	//print_r($data);exit;//测试是否抓取到页面数据
?>