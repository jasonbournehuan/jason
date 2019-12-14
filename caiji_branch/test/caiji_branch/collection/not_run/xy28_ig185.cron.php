<?php
	$typeid = 10025;//彩种ID
	$cron_name = '幸运28';//台湾宾果PC蛋蛋
echo '数据错误，不采集';exit;
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://ig185.com/kaijiangweb/getHistoryList.do?date=&lotCode=TWBGKL8_PCEGG";//抓取地址
    $datas = $this->cjig185->cj($url);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  4
	//print_r($data);exit;//打印格式化后的数据
?>