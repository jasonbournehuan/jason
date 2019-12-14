<?php
$typeid = 10002;
$cron_name = "广东快乐十分";
$url  = "https://b.cnyl168.com/Result/GetLotteryResultList?gameID=5&pageSize=50";
$result = $this->cjsdlnx->cj($url,'gdkl');
$data =  $result['data'];
$yid = $result['yid']; //8