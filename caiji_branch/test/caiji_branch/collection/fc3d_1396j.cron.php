<?php
	$typeid = 10010;//彩种ID
	$cron_name = '福彩3D';
    //每天 21:15开奖
    $int_time = intval(date("Hi", $_SERVER['time']));
    if($int_time < 2115){
        $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
        exit;
    }
	$url = 'https://m.1396j.com/fc3d/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule2");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID  3
?>