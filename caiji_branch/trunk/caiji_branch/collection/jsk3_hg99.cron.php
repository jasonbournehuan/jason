<?php
$typeid = 10005;//彩种ID
$cron_name = '江苏快三';
$url = "http://trend.gameabchart001.com/gameChart/JSK3/K3?rowNumType=2&lotteryName=%E6%B1%9F%E8%8B%8F%E5%BF%AB3";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  10
?>