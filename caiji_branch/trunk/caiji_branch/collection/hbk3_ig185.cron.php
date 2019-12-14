<?php
	$typeid = 10017;//彩种ID
	$cron_name = '湖北快三';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=HBK3";//抓取地址
    $datas = $this->cjig185->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  4
	//print_r($data);exit;//打印格式化后的数据
?>