<?php
	$typeid = 10004;//彩种ID
	$cron_name = '台湾宾果快乐8';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=TWBGKL8";//抓取地址
    $datas = $this->cjig185->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID    4
  //   print_r($data);exit;//打印格式化后的数据
?>