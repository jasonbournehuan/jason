<?php
	$typeid = 10007;//彩种ID
	$cron_name = '重庆时时彩';
	$url = "https://m.600w5.com:88/apis/ssc/getDataHistory.json";//要抓取数据的页面地址
    $playGroupId = 1;
    $datas = $this->cj600w5->cj($url,$playGroupId);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  2
?>