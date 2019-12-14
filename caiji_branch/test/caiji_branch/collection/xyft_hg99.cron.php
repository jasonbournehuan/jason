<?php
$typeid = 10021;//彩种ID
$cron_name = '幸运飞艇';
$url = "http://trend.gameabchart001.com/gameChart/XYFT/PK10DWD?lotteryName=%E5%B9%B8%E8%BF%90%E9%A3%9E%E8%89%87";//要抓取数据的页面地址
$result = $this->cjhg99->cj($url);
if(!empty($result['data']))
{
    foreach ($result['data'] as $key => $value)
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