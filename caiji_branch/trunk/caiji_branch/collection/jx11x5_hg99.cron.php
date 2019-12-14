<?php
$typeid = 10027;//彩种ID
$cron_name = '江西11选5';
$url = "http://trend.gameabchart001.com/gameChart/JX11X5/XX5?rowNumType=2&lotteryName=%E6%B1%9F%E8%A5%BF11%E9%80%895";//要抓取数据的页面地址
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