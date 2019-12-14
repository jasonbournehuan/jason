<?php
$typeid = 10026;//彩种ID
$cron_name = '江苏11选5';
$url = "https://1395q.com/news/index.php/index/elevenseize/getElevenFiveInfo?issue=&lotCode=10016";//抓取地址
		
$result = $this->cj1395q->cj($url,'change');
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