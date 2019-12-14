<?php
	$typeid = 10010;//彩种ID
	$cron_name = '福彩3D';
    //每天 21:15开奖
    $int_time = intval(date("Hi", $_SERVER['time']));
    if($int_time < 2115){
        $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
        exit;
    }
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://www.tiantiancai8.com/cp/resultHistory/2?new=1&pageCurrent=1";//抓取地址
    $datas = $this->cjttc->cj($url,"common");
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID 7
	//print_r($data);exit;//打印格式化后的数据
?>