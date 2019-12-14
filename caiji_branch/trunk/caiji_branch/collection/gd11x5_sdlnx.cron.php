<?php
$typeid = 10003;
$cron_name = "广东11选5";
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?gameID=45&pageSize=50";
$result = $this->cjsdlnx->cj($url);
$data   = $result['data'];
$yid    = $result['yid'];  //8
