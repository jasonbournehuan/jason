<?php
$typeid = 10017;//彩种ID
$cron_name = '湖北快三';
$url = "http://trend.gameabchart001.com/gameChart/HUBK3/K3?rowNumType=2&lotteryName=%E6%B9%96%E5%8C%97%E5%BF%AB3";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);
$data = $result['data'];

$yid = $result['yid'];//采集源ID  10
?>