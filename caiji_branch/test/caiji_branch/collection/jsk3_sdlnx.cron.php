<?php
$typeid = 10005;
$cron_name = "江苏快3";
$url  = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=22";
$result  = $this->cjsdlnx->cj($url);
$data = $result['data'];
$yid = $result['yid'];  //8