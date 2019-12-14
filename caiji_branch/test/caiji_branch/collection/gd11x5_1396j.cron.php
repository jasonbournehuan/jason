<?php
	$typeid = 10003;//彩种ID
	$cron_name = '广东11选5';
	$url = 'https://m.1396j.com/gd11x5/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule3");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID  3
?>