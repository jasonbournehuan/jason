<?php
$typeid = 10025;//彩种ID
$cron_name = '幸运28';
$url = "https://1395q.com/news/index.php/index/egxy28/getPcLucky28?issue=";//抓取地址
$result = $this->cj1395q->cj($url,'');
$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>