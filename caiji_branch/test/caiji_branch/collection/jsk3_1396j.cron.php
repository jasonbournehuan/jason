<?php
	$typeid = 10005;//彩种ID
	$cron_name = '江苏快3';
	$url = 'https://m.1396j.com/jsk3/history';//要抓取数据的页面地址
    $result_datas = $this->cj1396j->cj($url,"rule4");
    $data = $result_datas['data'];
    $yid = $result_datas['yid'];//采集源ID  3
?>