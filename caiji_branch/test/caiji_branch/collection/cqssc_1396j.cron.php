<?php
	$typeid = 10007;//彩种ID
	$cron_name = '重庆时时彩';
	$url = 'https://m.1396j.com/cqssc/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule3");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID  3
?>