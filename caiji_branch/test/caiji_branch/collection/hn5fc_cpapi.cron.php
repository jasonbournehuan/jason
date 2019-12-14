<?php
$typeid = 9999;//彩种ID
$cron_name = '河内五分彩';
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=hnwfc&count=50&date=";//抓取地址
$result = $this->cjcpapi->cj($url);
$data = $result['data'];//有延迟
$yid = $result['yid'];//采集源ID  4
//print_r($data);exit;//打印格式化后的数据
?>