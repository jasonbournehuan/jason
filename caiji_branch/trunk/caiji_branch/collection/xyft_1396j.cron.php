<?php
	$typeid = 10021;//彩种ID
	$cron_name = '幸运飞艇';
	$url = 'https://m.1396j.com/xyft/history';//要抓取数据的页面地址
    $result = $this->cj1396j->cj($url,"rule2");
    $data = $result['data'];
    $yid = $result['yid'];//采集源ID  3
?>