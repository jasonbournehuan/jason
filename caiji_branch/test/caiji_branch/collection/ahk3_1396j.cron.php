<?php
	$typeid = 10019;//彩种ID
	$cron_name = '安徽快三';
	$url = 'https://m.1396j.com/ahk3/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule1");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID  3
?>