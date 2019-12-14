<?php
	$typeid = 10027;//彩种ID
	$cron_name = '江西11选5'; 
	$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=46";//抓取地址
    $result = $this->cjsdlnx->cj($url);
    $data = $result['data'];
    $yid = $result['yid'];//采集源ID  8
	//print_r($result);exit;//打印格式化后的数据
?>