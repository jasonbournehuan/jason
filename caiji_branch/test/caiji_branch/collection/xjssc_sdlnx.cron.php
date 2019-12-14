<?php
$typeid = 10013;
$cron_name = "新疆时时彩";

$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=10";
$result = $this->cjsdlnx->cj($url,'gdkl');
$data =  $result['data'];
$yid = $result['yid']; //8