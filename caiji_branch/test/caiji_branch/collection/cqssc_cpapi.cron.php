<?php
$typeid = 10007;//彩种ID
$cron_name = '重庆时时彩';
// https://ig185.com/kjProgram/html/home.html	// 首页
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotteryList?lotKey=ssc&count=50";//抓取地址
$result = $this->cjcpapi->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>