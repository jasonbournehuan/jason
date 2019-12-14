<?php
$typeid = 10026;//彩种ID
$cron_name = '江苏11选5';
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=62";//要抓取数据的页面地址
$result = $this->cjsdlnx->cj($url,'gdkl');
$data = $result['data'];

$yid = $result['yid'];//采集源ID  8
?>