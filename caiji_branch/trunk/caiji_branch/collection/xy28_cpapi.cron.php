<?php
$typeid = 10025;//彩种ID
$cron_name = '幸运28';
$url = "https://www.caipiaoapi.com/hall/hallajax/apiGameList?lotKey=xy28&count=50&date=";//抓取地址

$result = $this->cjcpapi->cj($url,'xn28');
$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>