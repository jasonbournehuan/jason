<?php
$typeid = 10023;//彩种ID
$cron_name = '幸运农场';//重庆幸运农场
// http://www.sdlnx.com	// 首页
echo  '官方没有';exit;
$url = "http://www.sdlnx.com/api/GetLotteryResult.php?type=cqxync&size=50&format=json";//抓取地址
$datas = $this->cjsdlnx->cj($url);
if(!empty($datas['data']))
{

    foreach($datas['data']  as $key => $value)
    {
        $new_haoma = explode(',',$value['haoma']);
        $haoma_str = '';
        foreach($new_haoma as  $k => $v)
        {
            $haoma_str .= intval($v).',';
        }
        $datas['data'][$key]['haoma'] = substr($haoma_str,'0',strlen($haoma_str)-1);
    }

}
$data = $datas['data'];
$yid = $datas['yid'];//采集源ID   8
//print_r($data);exit;//打印格式化后的数据
?>