<?php
$typeid = 10009;//彩种ID
$cron_name = '双色球';
$url = "https://www.caim8.com/openApi/for_fresh";//抓取地址

$result = $this->cjcaim8->cj($url,26);
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
$yid = $result['yid'];//采集源ID 4
//print_r($data);exit;//打印格式化后的数据
?>