<?php
	$typeid = 10011;//彩种ID
	$cron_name = '大乐透';
	//每周一、三、六 20:30开奖
	$wayday = date("w", $_SERVER['time']);
	$int_time = intval(date("Hi", $_SERVER['time']));
	if(($wayday != 1 and $wayday != 3 and $wayday != 6) or $int_time < 2014){
		$this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
		exit;
	}
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "http://match.lottery.sina.com.cn/client/index/clientProxy?__caller__=web&__verno__=1&cat1=gameOpen&format=json&gameCode=201&page=1&_=1550867836563&callback=code";//抓取地址
    $result = $this->cjsina->cj($url,"dlt");
    $data = $result['data'];
    $yid = $result['yid'];//采集源ID  6
	//print_r($data);exit;//打印格式化后的数据
?>