<?php
 $typeid = 10018 ;
 $cron_name = "北京快3";

 $url = "https://www.caipiaoapi.com/hall/hallajax/getLotteryList?lotKey=bjk3&count=50&date=";

 $result = $this->cjcpapi->cj($url);
 $data = $result['data'];
 $yid = $result['yid']; //9
