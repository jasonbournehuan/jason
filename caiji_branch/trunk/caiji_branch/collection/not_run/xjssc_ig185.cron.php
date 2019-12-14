<?php
	$typeid = 10013;//彩种ID
	$cron_name = '新疆时时彩';
	// https://ig185.com/kjProgram/html/home.html	// 首页
    echo  '网站取消了彩种,暂时不运行。';exit;
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=XJSC";//抓取地址
    $datas = $this->cjig185->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  4
	//print_r($data);exit;//打印格式化后的数据
?>