<?php
    $typeid = 10010;//彩种ID
    $cron_name = '福彩3D';
    //每天 21:15开奖
    $int_time = intval(date("Hi", $_SERVER['time']));
    if($int_time < 2115){
        $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
        exit;
    }
    // https://ig185.com/kjProgram/html/home.html	// 首页
    $url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=fsd&count=50&date=";//抓取地址
    $result = $this->cjcpapi->cj($url);
    $data = $result['data'];
    $yid = $result['yid'];//采集源ID  9
    //print_r($data);exit;//打印格式化后的数据
?>