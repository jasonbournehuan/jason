<?php
        $typeid = 10019 ;
        $cron_name = "安徽快3";
        $url  = "https://www.caipiaoapi.com/hall/hallajax/getLotteryList?lotKey=ahk3&count=50&date=";


        $result = $this->cjcpapi->cj($url);
        $data  = $result['data'];
        $yid = $result['yid']; //9

