<?php
$typeid = 10008;
$cron_name = "六合彩";//香港六合彩
$url = "https://b.cnyl168.com/Result/GetLotteryResultList?pageSize=50&gameID=1";
$result = $this->cjsdlnx->cj($url);
if(!empty($result['data']))
{
    foreach($result['data'] as $key => $value)
    {
        $new_haoma = explode(',',$value['haoma']);
        $haoma_str = '';
        foreach($new_haoma as  $k => $v)
        {
            $haoma_str .= intval($v).',';
        }
        $result['data'][$key]['haoma']  = substr($haoma_str,'0',strlen($haoma_str)-1);
    }
}
$data = $result['data'];
$yid = $result['yid']; //8
