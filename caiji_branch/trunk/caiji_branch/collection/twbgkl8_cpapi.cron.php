<?php
	$typeid = 10004;//彩种ID
	$cron_name = '台湾宾果';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://www.caipiaoapi.com/hall/hallajax/getLotteryList?lotKey=twbg&count=203&date=";//抓取地址
    $result = $this->cjcpapi->cj($url);
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
?>