<?php
$typeid = 10013;//彩种ID
$cron_name = '新疆时时彩';
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=xjssc&count=50&date=";//抓取地址

$result = $this->cjcpapi->cj($url);
$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>