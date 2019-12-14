<?php
    $typeid = 10012;
    $cron_name = "天津时时彩";

    $url = "http://www.sdlnx.com/api/GetLotteryResult.php?type=tjssc&size=50&format=json";
    $result = $this->cjsdlnx->cj($url);

    $data = $result['data'];
    $yid = $result['yid'];//8


?>