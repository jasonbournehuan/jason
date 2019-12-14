<?php
$typeid = 10017;//彩种ID
$cron_name = '湖北快三';
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=hbk3&count=50&date=";//抓取地址

$result = $this->cjcpapi->cj($url);
$data = $result['data'];

$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>