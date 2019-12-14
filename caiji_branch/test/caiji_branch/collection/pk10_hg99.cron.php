<?php
$typeid = 10001;//彩种ID
$cron_name = '北京赛车';
$url = "http://trend.gameabchart001.com/gameChart/BJPK10/PK10DWD?lotteryName=%E5%8C%97%E4%BA%AC%E8%B5%9B%E8%BD%A6";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);
if(!empty($result['data']))
{
    foreach($result['data'] as  $key => $value)
    {
        $new_haoma = explode(',',$value['haoma']);
        foreach($new_haoma as $k  => $v)
        {
            $new_haoma[$k] = intval($v);
        }
        $result['data'][$key]['haoma'] = implode(',',$new_haoma);
    }
}

$data = $result['data'];
$yid = $result['yid'];//采集源ID  10
?>