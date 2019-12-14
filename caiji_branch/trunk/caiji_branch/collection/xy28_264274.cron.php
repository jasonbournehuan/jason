<?php
$typeid = 10025;//彩种ID
$cron_name = '幸运28';
$url = "http://api.264274.com/LuckTwenty/getPcLucky28.do?issue=";//抓取地址

$result = $this->cj264274->cj($url);
$data = $result['data'];

$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>