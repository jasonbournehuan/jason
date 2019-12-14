<?php
	$typeid = 10009;//彩种ID
	$cron_name = '双色球';
	/*
	//每周二、四、日 21:20开奖
	$wayday = date("w", $_SERVER['time']);
	$int_time = intval(date("Hi", $_SERVER['time']));
	if(($wayday != 2 and $wayday != 4 and $wayday != 0) or $int_time < 2120){
		$this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
		exit;
	}
	*/
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "http://match.lottery.sina.com.cn/client/index/clientProxy?__caller__=web&__verno__=1&cat1=gameOpen&format=json&gameCode=101&page=1&_=1550867836563&callback=code";//抓取地址
    $datas = $this->cjsina->cj($url,"ssq");
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID   6
	//print_r($data);exit;//打印格式化后的数据
?>