<?php
	$typeid = 10004;//彩种ID
	$cron_name = '台湾宾果';
	// https://ig185.com/kjProgram/html/home.html	// 首页
	$url = "https://api.api861861.com/LuckTwenty/getBaseLuckTewnty.do?issue=&lotCode=10047";//抓取地址	
    $result = $this->cjtw1680380->cj($url,'');
    if(!empty($result['data']))
	{
	    foreach($result['data'] as  $key => $value)
	    {
	    	$a = strrpos($value['haoma'],',');
	    	$aa = substr($value['haoma'],0,$a);//字符串处理去除多余的字符串
	        $new_haoma = explode(',',$aa);
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