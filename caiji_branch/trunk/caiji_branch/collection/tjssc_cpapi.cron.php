<?php
$typeid = 10012;//彩种ID
$cron_name = '天津时时彩';
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=tjssc&count=50&date=";//抓取地址

$result = $this->cjcpapi->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>