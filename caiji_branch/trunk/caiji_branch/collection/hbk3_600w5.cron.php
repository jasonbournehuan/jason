<?php
	$typeid = 10017;//彩种ID
	$cron_name = '湖北快三';
	$url = "https://m.600w5.com:88/apis/ssc/getDataHistory.json";//要抓取数据的页面地址
    $playGroupId = 19;
    $datas = $this->cj600w5->cj($url,$playGroupId);
    $data = $datas['data'];
   
    $yid = $datas['yid'];//采集源ID   2
	//print_r($data);exit;//测试是否抓取到页面数据
?>