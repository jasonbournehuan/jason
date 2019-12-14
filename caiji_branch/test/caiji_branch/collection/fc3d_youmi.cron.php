<?php
	$typeid = 10010;//彩种ID
	$cron_name = '福彩3D';
	//每天 21:15开奖
    $int_time = intval(date("Hi", $_SERVER['time']));
    if($int_time < 2115){
        $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
        exit;
    }
	$url = 'http://dm2212.com:90/Result/GetLotteryResultList?gameID=30&pageSize=30';//要抓取数据的页面地址
	$datas = $this->cjyoumi->cj($url,'hold');
	//过滤0
	$data = $datas['data'];
	$yid = $datas['yid'];//采集源ID  8
?>