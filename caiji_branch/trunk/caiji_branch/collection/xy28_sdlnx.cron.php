<?php
$typeid = 10025;
$cron_name = "幸运28";//北京28
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=101";
$result  = $this->cjsdlnx->cj($url);
$data = $result['data'];
$yid = $result['yid']; //8
