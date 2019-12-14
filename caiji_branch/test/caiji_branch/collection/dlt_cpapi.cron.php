<?php
$typeid = 10011;//彩种ID
$cron_name = '大乐透';
//每周一、三、六 20:30开奖
$wayday = date("w", $_SERVER['time']);
$int_time = intval(date("Hi", $_SERVER['time']));
if(($wayday != 1 and $wayday != 3 and $wayday != 6) or $int_time < 2014){
    $this->on_echo($date." 不在时间 ".$cron_name." 无需采集！\r\n");
    exit;
}
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=dlt&count=50&date=";//抓取地址
$result = $this->cjcpapi->cj($url);
if(!empty($result['data']))
{
    foreach($result['data'] as  $key => $value)
    {
        $new_haoma = explode(',',$value['haoma']);
        foreach($new_haoma as $k => $v)
        {
            $new_haoma[$k] = intval($v);
        }
        $result['data'][$key]['haoma'] = implode(',',$new_haoma);
    }
}

$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>