<?php
$typeid = 10017;
$cron_name = "湖北快3";
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=87";
$result = $this->cjsdlnx->cj($url);
$data = $result['data'];
 
$yid  = $result['yid'];  //8