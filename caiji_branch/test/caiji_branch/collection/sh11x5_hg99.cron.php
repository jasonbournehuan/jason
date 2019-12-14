<?php
$typeid = 10028;//彩种ID
$cron_name = '上海11选5';
$url = "http://trend.gameabchart001.com/gameChart/SH11X5/XX5?rowNumType=2&lotteryName=%E4%B8%8A%E6%B5%B711%E9%80%895";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url,'x5');

if(!empty($result['data']))
{
    foreach($result['data'] as $key => $value)
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
$yid = $result['yid'];//采集源ID  10
?>