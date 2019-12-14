<?php
$typeid = 10018;//彩种ID
$cron_name = '北京快3';
$url = "http://trend.gameabchart001.com/gameChart/BJK3/K3?rowNumType=2&lotteryName=%E5%8C%97%E4%BA%AC%E5%BF%AB3";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  10
?>