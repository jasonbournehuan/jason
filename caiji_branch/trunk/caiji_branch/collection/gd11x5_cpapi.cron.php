<?php
$typeid = 10003;//彩种ID
$cron_name = '广东11选5';
$url = "https://www.caipiaoapi.com/hall/hallajax/getLotterylist?lotKey=gdsyxw&count=50&date=";//抓取地址

$result = $this->cjcpapi->cj($url,'gd11x5');

if(!empty($result['data']))
{
    foreach($result['data'] as $key => $value)
    {
        $number =  explode(',',$value['haoma']);
        foreach($number as $k => $v)
        {
            $number[$k] = intval($v);
        }
        $result['data'][$key]['haoma'] = implode(',',$number);

    }

}
$data = $result['data'];
$yid = $result['yid'];//采集源ID  9
//print_r($data);exit;//打印格式化后的数据
?>