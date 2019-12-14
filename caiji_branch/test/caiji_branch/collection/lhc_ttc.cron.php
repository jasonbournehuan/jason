<?php
	$typeid = 10008;//彩种ID
	$cron_name = '六合彩'; //香港彩
	/*
	$wayday = date("w", $_SERVER['time']);
	$int_time = intval(date("Hi", $_SERVER['time']));
	if(($wayday != 1 and $wayday != 3 and $wayday != 6) or $int_time < 2030){
		$this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
		exit;
	}
	*/
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://www.tiantiancai8.com/cp/resultHistory/1?new=1&pageCurrent=1";//抓取地址
    $datas = $this->cjttc->cj($url,"lhc");
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID   7
	//print_r($data);exit;//打印格式化后的数据
?>