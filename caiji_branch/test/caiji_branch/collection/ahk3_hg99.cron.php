<?php
$typeid = 10019;//彩种ID
$cron_name = '安徽快三';
$url = "http://trend.gameabchart001.com/gameChart/AHK3/K3?rowNumType=2&lotteryName=%E5%AE%89%E5%BE%BD%E5%BF%AB3";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);

$data = $result['data'];
$yid = $result['yid'];//采集源ID  10
?>