<?php
    $typeid = 10010;
    $cron_name = "福彩3D";
    //每天 21:15开奖
    $int_time = intval(date("Hi", $_SERVER['time']));
    if($int_time < 2115){
        $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
        exit;
    }
    $url = "https://b.cnyl168.com/Result/GetLotteryResultList?gameID=30&pageSize=50";
    $result = $this->cjsdlnx->cj($url);
    $data = $result['data'];
    $yid = $result['yid'];  //8

?>