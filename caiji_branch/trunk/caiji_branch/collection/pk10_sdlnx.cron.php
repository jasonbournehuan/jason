<?php
    $typeid = 10001;
    $cron_name = "PK10";//北京pk10
    $url  = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=15";
    $result = $this->cjsdlnx->cj($url);
    $data = $result['data'];
    $yid = $result['yid']; //8
