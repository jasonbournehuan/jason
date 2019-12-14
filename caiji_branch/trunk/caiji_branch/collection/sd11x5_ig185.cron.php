<?php
	$typeid = 10029;//彩种ID
	$cron_name = '山东11选5';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=SD115";//抓取地址
    $datas = $this->cjig185->cj($url,'sd11x5');
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID 4
	//print_r($data);exit;//打印格式化后的数据
?>