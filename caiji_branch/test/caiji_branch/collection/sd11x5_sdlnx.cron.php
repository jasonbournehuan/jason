<?php
$typeid = 10029;//彩种ID
$cron_name = '山东11选5';
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=32";//要抓取数据的页面地址
$result = $this->cjsdlnx->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  8
?>