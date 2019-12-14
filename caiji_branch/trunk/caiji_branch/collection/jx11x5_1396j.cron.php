<?php
	$typeid = 10027;//彩种ID
	$cron_name = '江西11选5';
	$url = 'https://m.1396j.com/jx11x5/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule3");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID   3
?>