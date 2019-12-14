<?php
    $typeid = 10007 ;
    $cron_name = "重庆时时彩";
    $url = "https://b.cnyl168.com/Result/GetLotteryResultList?gameID=26&pageSize=50";
    $result = $this->cjsdlnx->cj($url);
    $data = $result['data'];
    $yid  = $result['yid'];  //8