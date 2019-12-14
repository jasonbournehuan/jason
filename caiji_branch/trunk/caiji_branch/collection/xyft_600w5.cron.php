<?php
	$typeid = 10021;//彩种ID
	$cron_name = '幸运飞艇';
	$url = "https://m.600w5.com:88/apis/ssc/getDataHistory.json";//要抓取数据的页面地址
    $playGroupId = 14;
    $result = $this->cj600w5->cj($url,$playGroupId);
    $data = $result['data'];
    $yid = $result['yid'];//采集源ID   2
	//print_r($data);exit;//测试是否抓取到页面数据
?>