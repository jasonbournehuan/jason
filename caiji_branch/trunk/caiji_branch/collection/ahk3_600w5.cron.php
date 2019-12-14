<?php
	$typeid = 10019;//彩种ID
	$cron_name = '安徽快三';
	$url = "https://m.600w5.com:88/apis/ssc/getDataHistory.json";//要抓取数据的页面地址
    $playGroupId = 20;
    $datas = $this->cj600w5->cj($url,$playGroupId);
    $data = $datas['data'];
    $yid = $datas['yid'];//采集源ID  2
?>