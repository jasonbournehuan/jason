<?php
$typeid = 10027;//彩种ID
$cron_name = '江西11选5';
$url = "https://1395q.com/news/index.php/index/elevenseize/getElevenFiveInfo?issue=&lotCode=10015";//抓取地址
$result = $this->cj1395q->cj($url,'');
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