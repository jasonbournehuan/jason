<?php
$typeid = 10013;//彩种ID
$cron_name = '新疆时时彩';
$url = "http://trend.gameabchart001.com/gameChart/XJSSC/SSC5?rowNumType=2&lotteryName=%E6%96%B0%E7%96%86%E6%97%B6%E6%97%B6%E5%BD%A9";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  10
?>