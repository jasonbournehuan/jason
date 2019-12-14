<?php
	$typeid = 10001;//彩种ID
	$cron_name = '北京PK10';
	$url = 'https://m.1396j.com/pk10/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule5");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID  3
?>