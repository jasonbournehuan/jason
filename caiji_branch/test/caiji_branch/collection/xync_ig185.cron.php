<?php
	$typeid = 10023;//彩种ID
	$cron_name = '幸运农场';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=XYC";//抓取地址
    $datas = $this->cjig185->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID   4
	//print_r($data);exit;//打印格式化后的数据
?>