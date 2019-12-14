<?php
$typeid = 10021;
$cron_name  = "幸运飞艇";
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=97";
$result = $this->cjsdlnx->cj($url);
$data = $result['data'];
$yid = $result['yid']; //8