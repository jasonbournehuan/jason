<?php
	$typeid = 10002;//彩种ID
	$cron_name = '广东快乐十分';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=KLC";//抓取地址
    $datas = $this->cjig185->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  4
	/*print_r($data);exit;//打印格式化后的数据*/
?>