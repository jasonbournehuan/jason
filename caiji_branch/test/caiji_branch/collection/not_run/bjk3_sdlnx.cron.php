<?php
    $typeid = 10018;
    $cron_name = "北京快3";
    echo '网站取消了彩种。';exit;
    $url = "http://www.sdlnx.com/api/GetLotteryResult.php?type=bjk3&size=50&format=json"; //https://b.cnyl168.com/Result/GetLotteryResultList?gameID=82&pageSize=50&pageIndex=1
    $result = $this->cjsdlnx->cj($url);
    $data = $result['data'];
    $yid  = $result['yid'];  // 8
