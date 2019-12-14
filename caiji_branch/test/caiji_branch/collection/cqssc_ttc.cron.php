<?php
	$typeid = 10007; //彩种ID
	$cron_name = '重庆时时彩';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://www.tiantiancai8.com/cp/resultHistory/4?new=1&pageCurrent=1";//抓取地址
    $datas = $this->cjttc->cj($url,"common");
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  7
	//print_r($data);exit;//打印格式化后的数据
?>